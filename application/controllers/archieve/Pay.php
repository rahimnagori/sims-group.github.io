<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Common_Model');
    $this->load->library('session');
  }

  private function get_logged_in_userdata(){
    $where['id'] = $this->session->userdata('user_id');
    $userdata = $this->Common_Model->fetch_records('users', $where, false, true);
    return $userdata;
  }

  public function index(){
    $response['status'] = 0;
    if($this->session->has_userdata('is_user_logged_in')){
      $userdata = $this->get_logged_in_userdata();
    }
    if(!empty($userdata)){
      $stripeCustomerId = $this->input->post('stripe_cust_id');

      // $whereCustomer['user_id'] = $userdata['id'];
      // $checkPlan = $planDetails = $this->Common_Model->fetch_records('stripe_customers', $whereCustomer, false, true);
      // if($checkPlan){
        // $response['status'] = 2;
        // $response['responseMessage'] = 'You are not authorized.';
      // }else{
        $insertResponse['response'] = json_encode($_REQUEST);
        $insertResponse['date'] = date("Y-m-d H:i:s");
        $insertResponse['user_id'] = $userdata['id'];
        $insertResponse['type'] = 'Stripe Success';
        $this->Common_Model->insert('responses', $insertResponse);
        $plan_id = $this->input->post('plan_id');

        $planDetails = $this->Common_Model->fetch_records('plans', array('id' => $plan_id), false, true);
        $duration = 1;

        $insertUserPlan['user_id'] = $userdata['id'];
        $insertUserPlan['plan_id'] = $plan_id;
        $insertUserPlan['credits'] = $planDetails['monthly_credits'];
        $insertUserPlan['plan_start_date'] = $insertUserPlan['created'] = date("Y-m-d H:i:s");
        $insertUserPlan['plan_end_date'] = date('Y-m-d H:i:s', strtotime("+$duration months"));
        $insertUserPlan['created'] = date("Y-m-d H:i:s");
        $insertUserPlan['booking_id'] = uniqid();
        $insertUserPlan['is_canceled'] = 0;
        $this->Common_Model->insert('user_plans', $insertUserPlan);
        
        $insertTransactions['payment_gateway_id'] = $this->input->post('payment_gateway_id');
        $insertTransactions['product_id'] = $insertUserPlan['plan_id'];
        $insertTransactions['booking_id'] = $insertUserPlan['booking_id'];
        $insertTransactions['user_id'] = $insertUserPlan['user_id'];
        $insertTransactions['amount'] = $planDetails['plan_fee'];
        $insertTransactions['product_type'] = 'plan_puchase';
        $insertTransactions['created'] = $insertUserPlan['created'];
        $this->Common_Model->insert('transactions', $insertTransactions);

        $insertStripeCustomer['user_id'] = $userdata['id'];
        $insertStripeCustomer['customer_id'] = $stripeCustomerId;
        $insertStripeCustomer['created'] = date("Y-m-d H:i:s");
        $insertStripeCustomer['payment_method'] = $this->input->post('payment_method');
        if($this->Common_Model->insert('stripe_customers', $insertStripeCustomer)){
          $whereUser['id'] = $userdata['id'];
          $updateUserCredit['total_credits'] = $userdata['total_credits'] + $planDetails['monthly_credits'];
          $this->Common_Model->update('users', $whereUser, $updateUserCredit);
          $response['status'] = 1;
          $response['responseMessage'] = 'Subscribed successfully.';
          $response['transaction_id'] = $insertTransactions['booking_id'];
        }
      // }

      // $this->send_payment_confirmation($user_id);
    }else{
      $response['status'] = 2;
      $response['responseMessage'] = 'You are not authorized.';
    }
    echo json_encode($response);
  }

  public function Recurring(){
    require_once('assets/stripe-php/vendor/autoload.php');
    /*
    Development
    $stripe = [
      "secret_key"      => "sk_test_RLP8zOE4pKqmA3KNdxlJY1Ax00jkn56D8H",
      "publishable_key" => "pk_test_MhlEF31rEHnaQLsEMrsFeHXn00Ht1feSEr",
    ];
    */
    /* Client test */
    $stripe = [
      "secret_key"      => "sk_test_51HvgPbIRj8C8zIODBc8cwVkibpwyUD1POtmVJzGY9eAYsIwBlYi6Cqrv2KtoiApxcCDwJaLIuGTwfxJg7tvfODFQ00t7TW6y2J",
      "publishable_key" => "pk_test_51HvgPbIRj8C8zIODYJBMUrMiF0IXCqYpmnarNjfgi7KwGWqpwX3HGhKBsRHkBYgrA1XeZ7JJAiXBlDAbrIpNgonC00feWjmmMK",
    ];
    /* Client Live 
    $stripe = [
      "secret_key"      => "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",
      "publishable_key" => "pk_live_51HvgPbIRj8C8zIODjtga1YyLWfjWDdWO2XzBKulhZBHq3DBOoy10g1o2mppTYDpf05oa3b3Pa6uIE7ocOZLA2a4000iHM7UJ1k",
    ];
    */
    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    $stripeCustomers = $this->Common_Model->fetch_records('stripe_customers');
    foreach($stripeCustomers as $stripeCustomer){
      $whereUserPlan['user_id'] = $stripeCustomer['user_id'];
      $userPlan = $this->Common_Model->fetch_records('user_plans', $whereUserPlan, false, true, 'id');
      if($userPlan['plan_end_date'] <= date("Y-m-d H:i:s")){
        $wherePlan['id'] = $userPlan['plan_id'];
        $planDetails = $this->Common_Model->fetch_records('plans', $wherePlan, false, true);

        $stripe_customer_id = $stripeCustomer['customer_id'];
        $stripe_payment_method = $stripeCustomer['payment_method'];
        try {
          $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => $planDetails['plan_fee'] * 100,
            'currency' => 'usd',
            'off_session' => 'true',
            'confirm' => 'true',
            'customer' => $stripe_customer_id,
            'payment_method' =>$stripe_payment_method
          ]);
          $payment_intent_id = $payment_intent->id;
         
        } catch (\Stripe\Exception\CardException $e) {
          $payment_intent_id = $e->getError()->payment_intent->id;
        }
        $payment_intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);

        if($payment_intent->status && $payment_intent->status == 'succeeded'){
          $insertResponse['response'] = json_encode($payment_intent);
          $insertResponse['date'] = date("Y-m-d H:i:s");
          $insertResponse['user_id'] = $userPlan['user_id'];
          $insertResponse['type'] = 'Stripe Recurring';
          $this->Common_Model->insert('responses', $insertResponse);

          $duration = $planDetails['plan_duration'];

          $insertUserPlan['user_id'] = $userPlan['user_id'];
          $insertUserPlan['plan_id'] = $userPlan['plan_id'];
          $insertUserPlan['credits'] = $planDetails['monthly_credits'];
          $insertUserPlan['plan_start_date'] = $insertUserPlan['created'] = date("Y-m-d H:i:s");
          $insertUserPlan['plan_end_date'] = date('Y-m-d H:i:s', strtotime("+$duration months"));
          $insertUserPlan['created'] = date("Y-m-d H:i:s");
          $insertUserPlan['booking_id'] = uniqid();
          $insertUserPlan['is_canceled'] = 0;
          $this->Common_Model->insert('user_plans', $insertUserPlan);

          $insertTransactions['payment_gateway_id'] = $payment_intent->id;
          $insertTransactions['product_id'] = $userPlan['plan_id'];
          $insertTransactions['booking_id'] = $insertUserPlan['booking_id'];
          $insertTransactions['user_id'] = $userPlan['user_id'];
          $insertTransactions['amount'] = $planDetails['plan_fee'];
          $insertTransactions['product_type'] = 'plan_re_purchased';
          $insertTransactions['created'] = $insertUserPlan['created'];
          $this->Common_Model->insert('transactions', $insertTransactions);

          $whereUser['id'] = $userPlan['user_id'];
          $userDetails = $this->Common_Model->fetch_records('users', $whereUser, false, true);
          $updateUserCredit['total_credits'] = $userDetails['total_credits'] + $planDetails['monthly_credits'];
          $this->Common_Model->update('users', $whereUser, $updateUserCredit);
        }else{
          $insertTransactions['payment_gateway_id'] = $payment_intent->id;
          $insertTransactions['product_id'] = $userPlan['plan_id'];
          $insertTransactions['booking_id'] = '';
          $insertTransactions['user_id'] = $userPlan['user_id'];
          $insertTransactions['amount'] = $planDetails['plan_fee'];
          $insertTransactions['product_type'] = 'plan_failed';
          $insertTransactions['created'] = date("Y-m-d H:i:s");
          $this->Common_Model->insert('transactions', $insertTransactions);
        }
      }
    }
  }

  private function send_payment_confirmation($user_id){
    $joins[0][] = 'user_plans';
    $joins[0][] = 'users.id = user_plans.user_id';
    $joins[0][] = 'left';
    $where['users.id'] = $user_id;
    $userdata = $this->Common_Model->join_records('users', $joins, $where, '*', 'user_plans.id');
    $userdata = $userdata[0];
    $planDetails = $this->Common_Model->fetch_records('plans', array('id' => $userdata['plan_id']));

    $subject = 'Subscription purchased successfully.';
    $body = '<p>Hello ' .$userdata['name'] .',</p>';
    $body .= '<p>This is to inform you that your subscription has been started.</p>';
    $body .= '<p>Below is your subscription details.</p>';
    $body .= '<table style="width:100%;">
      <thead>
        <tr>
        <th>Plan Name</th>
        <th>Plan Fee</th>
        <th>Plan Start Date</th>
        <th>Plan End Date</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="text-align: center;">' .$planDetails[0]['title'] .'</td>
          <td style="text-align: center;">$' .$planDetails[0]['plan_fee'] .'</td>
          <td style="text-align: center;">' .date("d M, Y", strtotime($userdata['plan_start_date'])) .'</td>
          <td style="text-align: center;">' .date("d M, Y", strtotime($userdata['plan_end_date'])) .'</td>
        </tr>
      </tbody>
    </table>';

    $this->Common_Model->send_mail($userdata['email'], $subject, $body);
  }

}
