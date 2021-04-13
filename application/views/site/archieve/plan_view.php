<?php
  include_once'include/header.php';
?>

<link href="<?=site_url('assets/stripe-php/assets/global.css');?>"></script>
<link href="<?=site_url('assets/stripe-php/assets/normalize.css');?>"></script>
<link href="<?=site_url('assets/stripe-php/assets/stripe.css');?>"></script>

<style type="text/css">
  #card_holder_warning{
    display:none;
  }
  .pro_img img {
    width: 250px;
    height: 250px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  }
  .img_counter_banner{
    min-height: 250px;
  }
  .pro_img {
    margin-top: -150px;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile {
    background: #fff !important;
    box-shadow: 0px 7px 8px rgba(121, 121, 121, 0.14);
    position: relative;
    margin-bottom: 0;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile {
    background: #fff !important;
  }
  .img_counter_profile .mb-4.community_heading {
    color: #000 !important;
    font-size: 28px !important;
    font-weight: 500;
  }
  .img_counter_profile .subheading {
    color: #000 !important;
    padding: 0 !important;
  }
  .social {
    display: flex;
    flex-wrap: wrap;
  }
  .div1 {
    margin-right: 20px;
    font-size: 13px;
    font-weight: 400;
    margin-top: 5px;
    color: #9d9d9d;
  }
  .div1 i {
    font-size: 14px;
    margin-right: 5px;
  }
  .theme_color {
    color: #572626;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile.bottom_sec{
  background-color: #f1f1f1 !important;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile.bottom_sec .destination .img {
    display: block;
    height: 130px;
    background-color: #f8faff;
    border-radius: 15px;
    box-shadow: 0 6px 8px #0000001c;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile.bottom_sec .destination .text h3 a {
    color: #572626;
    font-weight: 400;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100px;
    display: block;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile.bottom_sec .destination .text {
    padding: 10px 5px !important;
  }
  .ftco-section.ftco-counter.img.img_counter2.img_counter_profile.bottom_sec .btn.pricing-plan-purchase-btn.download {
    background: #572626;
    color: #fff;
    font-size: 13px !important;
    font-weight: 500;
    width: 240px;
    height: 40px;
    margin: 0;
  }
  .like {
    float: right;
    color: #572626;
  }
  .credit {
    display: block;
    height: 30px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 15px;
  }
</style>

<?php
  include_once 'include/profile_header.php';
?>

<section class="ftco-section ftco-counter img img_counter2 img_counter_profile bottom_sec">
  <div class="container">
    <div class="row justify-content-center">
      <?php
        include_once 'include/profile-sidebar.php';
      ?>
      <div class="col-md-7">
        <div class="Payment_bbo1">
          <div class="Payment_bbo2">
            <p>
              Credit Balance <span><?=round($userdata['total_credits'], 0);?></span>
            </p>
            <div class="form-group" style="display:none;" >
              <input type="number" name="request_amount" id="request_amount" class="form-control">
              <h5 id="amountError" class="text-danger"></h5>
            </div>
            <div class="form-group" style="display:none;">
              <button type="button" class="btn pricing-plan-purchase-btn download" id="request_btn" onclick="request_withdrawal();" style="width: 100%;font-size: 16px !important;">Request</button>
            </div>
          </div>
        </div>
        <?php
          if(!empty($userdata['userPlans'])){
        ?>
            <div class="row">
              <div class="col-sm-12">
                <?php
                  if($userdata['userPlans']['is_canceled'] == 0){
                ?>
                    <div class="aterre">
                      <p class="alert alert-success"> Current Plan : <?=$plans[$userdata['userPlans']['plan_id']]['plan_name'];?> | Start Date : <?=date("d M Y", strtotime($userdata['userPlans']['plan_start_date']));?> | End Date : <?=date("d M Y", strtotime($userdata['userPlans']['plan_end_date']));?> </p>
                    </div>
                    <div class="aterre">
                      <button type="button" class="btn btn-danger" onclick="cancel_subscription(<?=$userdata['userPlans']['plan_id'];?>);" >Cancel Subscription</button>
                      <p>To subscribe to a new plan, cancel the current subscription first.</p>
                    </div>
                <?php
                  }else{
                ?>
                    <div class="aterre">
                      <p class="alert alert-danger"> Last Plan : <?=$plans[$userdata['userPlans']['plan_id']]['plan_name'];?> | Start Date : <?=date("d M Y", strtotime($userdata['userPlans']['plan_start_date']));?> | End Date : <?=date("d M Y", strtotime($userdata['userPlans']['plan_end_date']));?> | Canceled Date : <?=date("d M Y", strtotime($userdata['userPlans']['canceled_date']));?> </p>
                    </div>
                <?php
                  }
                ?>
              </div>
            </div>
        <?php
          }
        ?>
        <div class="row main_pallh" >
          <?php
            foreach($plans as $plan){
              $planClass = ($userdata['userPlans']['is_canceled'] == 0 && $userdata['userPlans']['plan_id'] == $plan['id']) ? 'selected-plan' : '';
          ?>
              <div class="col-md-4 <?=$planClass;?>">
                <div class="card pricing-card pricing-plan-basic">
                  <div class="card-body"><i class="fa fa-free-code-camp" aria-hidden="true"></i>
                    <p class="pricing-plan-title"><?=$plan['plan_name'];?></p>
                    <h3 class="pricing-plan-cost ml-auto">$<?=$plan['plan_fee'];?>
                    </h3>
                    <?=$plan['plan_description'];?>
                    <?php
                      if(!empty($userdata['userPlans'])){
                        if($userdata['userPlans']['plan_id'] == $plan['id']){
                    ?>
                          <?php
                            if($userdata['userPlans']['is_canceled'] != 0){
                          ?>
                              <button type="button"  onclick="pay_with_stripe(<?=$plan['id'];?>);" class="btn pricing-plan-purchase-btn btn-info paypal_btn" id="stripe_btn_<?=$plan['id'];?>" >Purchase</button>
                          <?php
                            }
                          ?>
                      <?php
                        }else{
                      ?>
                          <?php
                            if($userdata['userPlans']['is_canceled'] != 0){
                          ?>
                              <button type="button"  onclick="pay_with_stripe(<?=$plan['id'];?>);" class="btn pricing-plan-purchase-btn btn-info paypal_btn" id="stripe_btn_<?=$plan['id'];?>" >Purchase</button>
                          <?php
                            }
                          ?>
                      <?php
                        }
                      ?>
                    <?php
                      }else{
                    ?>
                        <button type="button"  onclick="pay_with_stripe(<?=$plan['id'];?>);" class="btn pricing-plan-purchase-btn btn-info paypal_btn" id="stripe_btn_<?=$plan['id'];?>" >Purchase</button>
                    <?php
                      }
                    ?>
                  </div>
                </div>
              </div>
          <?php
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  include_once'include/footer.php';
?>

<!-- modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h4 class="modal-title">Payment Successful</h4>
        <button type="button" onclick="return location.reload();" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
      </div>
      <div class="modal-body connnsdfon">
        <div class="email_box1">
          <div class="icon_us">
            <img src="<?=site_url('assets/site/images/riight.png');?>">
          </div>
          <h4>Congratulations!!</h4>
          <p>
            Thank you for your payment. Your transaction has been completed and we've emailed you a receipt for your purchase.
            <!--
            Log in to your account to view transaction details
            -->
            <br/>
            Transaction ID: #<span id="transaction_id"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="location.reload();" class="btn btn-success"> Close </button>
      </div>
      
    </div>
  </div>
</div>
<!-- modal close -->

<!-- modal -->
<div class="modal fade" id="stripeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h4 class="modal-title">Pay with Stripe</h4>
        <button type="button" onclick="return location.reload();" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
      </div>
      <div class="modal-body connnsdfon">
        <div class="sr-root">
          <div class="sr-main">
            <div class="sr-payment-form payment-view">
              <div class="sr-form-row man_payyyme">
                <label for="card-element">
                  Card Holder Name
                </label>
                <div class="sr-combo-inputs">
                  <div class="sr-combo-inputs-row">
                    <input type="text" id="card_holder_name" placeholder="Card Holder Name" autocomplete="cardholder" class="form-control sr-input" value="<?=$userdata['first_name'] .' ' .$userdata['last_name'];?>" />
                    <p class="text-danger" id="card_holder_warning"> Please enter name. </p>
                  </div>
                  <div class="sr-combo-inputs-row">
                    <div class="sr-input sr-card-element" id="card-element"></div>
                  </div>
                </div>
                <div class="sr-field-error" id="card-errors" role="alert"></div>
                <div class="sr-form-row">
                  <label class="sr-checkbox-label">
                    <input style="display:none" disabled checked type="checkbox" id="save-card"><span class="sr-checkbox-check" ></span> This plan will be auto renewed.</label>
                </div>
              </div>
              <button id="stripe_checkout_btn" class="btn btn-success" >Checkout</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal close -->

<div class="modal fade" id="paymentFailureModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
        <h4 class="modal-title">Payment Failed</h4>
      </div>
      <div class="modal-body connnsdfon">
        <p> Your payment has been Failed. </p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-success"> Close </button>
      </div>
    </div>
  </div>
</div>
<!-- modal close -->

<script src="https://js.stripe.com/v3/"></script>
<script src="<?=site_url('assets/stripe-php/assets/stripe.js');?>?time=<?=time();?>"></script>

<script>
  function cancel_subscription(plan_id){
    if(confirm("Are you sure want to cancel your subscription?")){
      $.ajax({
        type:'POST',
        url: base_url + 'Plans/cancel_stripe_subscription',
        data:{},
        dataType:'JSON',
        beforeSend:function(){
        },
        success:function(response){
          location.reload();
        }
      });
    }
  }
</script>