<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plans extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   * 		http://example.com/index.php/Home
   *	- or -
   * 		http://example.com/index.php/Home/index
   *	- or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/Home/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function __construct(){
    parent::__construct();
    $this->load->model('Common_Model');
    $this->load->library('session');
    if(!$this->session->userdata('user_id')){
      redirect('');
    }
  }

  private function get_userdata(){
    $userdata = [];
    $user_id = $this->session->userdata('user_id');
    if($user_id){
      $userdata = $this->Common_Model->fetch_records('users', array('id' => $user_id), false, true);
    }
    $categories = $this->Common_Model->fetch_records('categories', array('parent_category' => 0));

    $collections = $this->Common_Model->fetch_records('collections');
    return array('userdata' => $userdata, 'categories' => $categories, 'collections' => $collections);
  }

  public function index(){
    $pageData = $this->get_userdata();
    if(empty($pageData['userdata'])) redirect('');
    if($pageData['userdata']['is_email_verified'] != 1) redirect('Email-Verify');

    $pageData['plans'] = [];
    $plans = $this->Common_Model->fetch_records('plans');
    foreach($plans as $plan){
      $pageData['plans'][$plan['id']] = $plan;
    }
    $whereUserPlan['user_id'] = $pageData['userdata']['id'];
    $pageData['userdata']['userPlans'] = $this->Common_Model->fetch_records('user_plans', $whereUserPlan, false, true, 'id');

    $this->load->view('site/plan_view', $pageData);
  }

  public function create_payment_intent(){
    require_once('assets/stripe-php/vendor/autoload.php');
    /* Development */
    $stripe = [
      "secret_key"      => "sk_test_RLP8zOE4pKqmA3KNdxlJY1Ax00jkn56D8H",
      "publishable_key" => "pk_test_MhlEF31rEHnaQLsEMrsFeHXn00Ht1feSEr",
    ];

    \Stripe\Stripe::setApiKey($stripe['secret_key']);

    $wherePlan['id'] = $this->input->post('plan_id');
    $planDetails = $this->Common_Model->fetch_records('plans', $wherePlan, false, true);

    $user_id = $this->session->userdata('user_id');
    $whereUser['id'] = $user_id;
    $userdata = $this->Common_Model->fetch_records('users', $whereUser, false, true);

    $customer = \Stripe\Customer::create([
      'email' => $userdata['email'],
    ]);

    $setupIntent = \Stripe\PaymentIntent::create([
      'amount' => $planDetails['plan_fee'] * 100,
      'currency' => 'USD',
      'customer' => $customer->id,
      'setup_future_usage' => 'off_session',
      'payment_method_types'=>['card'],
    ]);
    $setupIntent['stripe_customer_id'] = $customer->id;
    $setupIntent['total_amount'] = $planDetails['plan_fee'];
    $setupIntent['publicKey'] = $stripe['publishable_key'];
    echo json_encode($setupIntent);
  }

  public function cancel_stripe_subscription(){
    $response['status'] = 0;
    $where['user_id'] = $this->session->userdata('user_id');

    $where['is_canceled'] = 0;
    $planDetails = $this->Common_Model->fetch_records('user_plans', $where, false, true);
    $update['is_canceled'] = 1;
    $update['canceled_date'] = date("Y-m-d H:i:s");
    if($this->Common_Model->update('user_plans', $where, $update)){
      $this->Common_Model->delete('stripe_customers', array('user_id' => $where['user_id']));
    }
    echo json_encode($response);
  }

}
