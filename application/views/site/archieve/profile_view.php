<?php
  include_once'include/header.php';
?>

<style type="text/css">
  .pause_btn, .play_loader{
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
        <h6 class="mb-2">Favorites</h6>
        <div class="row">
          <div class="col-md-12">
            <div class="row justify-content-center community" style="justify-content: left !important;">
              <?php
                foreach($likedSounds as $likedSound){
              ?>
                  <div class="col-md-3">
                    <div class="destination">
                      <a href="<?=$BASE_URL .'Collection-Details/' .$likedSound['sound_collection_id'];?>" class="img d-flex justify-content-center align-items-center" style="background-image: url(<?=$BASE_URL .$likedSound['sound_artwork'];?>);">
                        <div class="icon d-flex justify-content-center align-items-center">
                          <span class="icon-search2"></span>
                        </div>
                      </a>
                      <div class="text p-3">
                        <h3><a href="#"><?=$likedSound['sound_title'];?></a></h3>
                        <div class="favtarrr">
                          <span class="listing"><?=isset($categories[$likedSound['sound_category']]) ? $categories[$likedSound['sound_category']]['name'] : '';?></span>
                        <a href="javascript:void(0);" onclick="like_dislike(<?=$likedSound['sound_id'];?>, true);" id="like_dislike_<?=$likedSound['sound_id'];?>" >
                          <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
                }
              ?>
              <?php
                if(!count($likedSounds)){
              ?>
                  <div class="col-sm-12">
                    <div class="text-center">
                      <img src="<?=$BASE_URL;?>assets/site/images/music_icon.png" >
                    </div>
                  </div>
              <?php
                }
              ?>
            </div>
          </div>
        </div>

        <h6 class="mb-2">Downloads</h6>
        <audio controls id="profile-audio-player" style="display:none;" title="" ontimeupdate="update_time(this.currentTime, this.duration);" onended="pause_all();" ></audio>
        <div class="row">
          <div class="col-md-12">
            <div class="row justify-content-center community" style="justify-content: left !important;">
              <?php
                foreach($downloadedSounds as $downloadedSound){
              ?>
                  <div class="col-md-3">
                    <div class="destination">
                      <a href="javascript:void(0);" class="img d-flex justify-content-center align-items-center" style="background-image: url(<?=$BASE_URL .$downloadedSound['sound_artwork'];?>);" onclick="play_pause(<?=$downloadedSound['sound_id'];?>, <?=$downloadedSound['sound_type'];?>);" >
                        <?php
                          if($downloadedSound['sound_type'] == 3){
                        ?>
                            <div class="icon d-flex justify-content-center align-items-center play_btn" id="play_btn_<?=$downloadedSound['sound_id'];?>" >
                              <i class="fa fa-download" aria-hidden="true"></i>
                            </div>
                        <?php
                          }else{
                        ?>
                            <div class="icon d-flex justify-content-center align-items-center play_btn" id="play_btn_<?=$downloadedSound['sound_id'];?>" >
                              <i class="fa fa-play" aria-hidden="true"></i>
                            </div>
                        <?php
                          }
                        ?>

                        <div class="icon justify-content-center align-items-center pause_btn" id="pause_btn_<?=$downloadedSound['sound_id'];?>">
                          <i class="fa fa-pause" aria-hidden="true"></i>
                        </div>
                        <div class="icon justify-content-center align-items-center play_loader" id="loader_btn_<?=$downloadedSound['sound_id'];?>" >
                          <i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
                        </div>
                      </a>
                      <div class="text p-3">
                        <h3><a href="#"><?=$downloadedSound['sound_title'];?></a></h3>
                        <div class="favtarrr">
                          <span class="listing"><?=isset($categories[$downloadedSound['sound_category']]) ? $categories[$downloadedSound['sound_category']]['name'] : '';?></span>
                          <!--
                          <a href="javascript:void(0);" onclick="like_dislike(<?=$downloadedSound['sound_id'];?>, true);" id="like_dislike_<?=$downloadedSound['sound_id'];?>" >
                            <i class="fa fa-heart" aria-hidden="true"></i>
                          </a>
                          -->
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
                }
              ?>
              <?php
                if(!count($downloadedSounds)){
              ?>
                  <div class="col-sm-12">
                    <div class="text-center">
                      <img src="<?=$BASE_URL;?>assets/site/images/music_icon.png" >
                    </div>
                  </div>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  include_once'include/footer.php';
?>

<script src="<?=site_url('assets/site/js/play.js?time=' .time());?>"></script>