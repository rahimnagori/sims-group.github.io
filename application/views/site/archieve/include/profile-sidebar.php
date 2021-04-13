<div class="col-md-3">
  <!--
  <div class="div1">
    <i class="fa fa-phone" aria-hidden="true"></i>
    <span class="theme_color"><?=$userdata['phone'];?></span>
  </div>
  <div class="div1">
    <i class="fa fa-envelope-o" aria-hidden="true"></i>
    <span class="theme_color"><?=$userdata['email'];?></span>
  </div>
  -->

  <br>
  <a href="<?=$BASE_URL;?>Profile" class="btn pricing-plan-purchase-btn download">Profile</a>
  <br>
  <a href="<?=$BASE_URL;?>Edit-Profile" class="btn pricing-plan-purchase-btn download">Edit Profile</a>
  <br>
  <a href="<?=$BASE_URL;?>Plan" class="btn pricing-plan-purchase-btn download">Purchase Plan</a>
  <br>

  <div class="div1" style="display:none;">
    <h6 class="theme_color">Credit</h6>
    <a href="#" class="credit"><?=round($userdata['total_credits'], 0);?></a>
  </div>

  <?php
    if(false){
  ?>
      <div class="div1">
        <h6>Bio</h6>
        <p><?=$userdata['about'];?></p>
      </div>
  <?php
    }
  ?>

  <div class="div1">
    <h6 class="theme_color"><a href="<?=$BASE_URL;?>Logout" style="text-decoration: underline;">Logout</a></h6>
  </div>
</div>