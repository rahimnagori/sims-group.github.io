<?php
include_once'include/header.php';
?>

<style>
  .ftco-navbar-light {
    z-index: 9999;
  }
  .pause_btn, #audio_play, .music-duration, .play_pause_btn{
    display:none;
  }
  img#audio_play {
    width: 100px;
    position: absolute;
    right: 30px;
    bottom: 30px;
  }
  .music-duration {
    position: absolute;
    right: 20px;
    bottom: 10px;
    font-weight: 600;
  }
  .play-pause-div {
    position: relative;
  }
  .play-pause-div img {
    width: 80px;
    height: 80px;
    border-radius: 13px;
  }
  .play-pause-div a {
    font-size: 15px !important;
    position: absolute;
    top: 30%;
    margin-top: 0;
    left: 23px !important;
    padding-top: 0;
  }
  .pause_btn i {
    background: #8e8e8e;
    text-align: center;
    height: 35px;
    width: 35px;
    background: #0006;
    border-radius: 50%;
    left: 30px;
    color: #fff;
    text-align: center;
    margin-right: 10px;
    padding-top: 10px;
  }
  .music-duration span {
    color: #fff;
    font-size: 15px;
    margin-top: ;
  }
  .qodef--play.stem_button {
    background: #fff;
    width: 35px;
    border-radius: 100%;
    height: 35px;
    line-height: 35px;
    text-align: center;
  }
</style>

<section class="ftco-section ftco-counter img img_counter2" id="section-counter" style="background-image: url(<?=$BASE_URL;?>assets/site/images/back.jpg);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
        <h2 class="mb-4 community_heading"><?=$collectionDetails['collection_name'];?></h2>
        <span class="subheading"><?=$collectionDetails['collection_description'];?></span>
      </div>
    </div>
  </div>
</section>


<section class="ftco-section ftco-destination" style="padding: 3em 0 0;">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-7">
        <div class="qodef-shortcode qodef-m  qodef-tracks-list qodef-layout--standard qodef--has-artist " data-album-id="552">
          <div id="qodef-m-track-player-552" class="qodef-m-track-player" style="display:none;">
            <img id="jp_poster_1" style="">
            <audio controls id="jp_audio_1" title="Black Hole Sun" ontimeupdate="update_time(this.currentTime, this.duration);" onended="pause_all();" ></audio>
          </div>
          <div class="qodef-m-artist" style="background-image: url('<?=$BASE_URL;?>assets/site/images/img2.jpg')">
            <img src="<?=$BASE_URL .$collectionDetails['collection_icon'];?>" class="qodef-m-artist-image" alt="v" srcset="<?=$BASE_URL .$collectionDetails['collection_icon'];?>" sizes="(max-width: 280px) 100vw, 280px" width="280" height="280"> 
            <div class="qodef-m-artist-content">
               <h4 itemprop="author" class="qodef-m-artist-content-name"><?=$collectionDetails['collection_name'];?></h4>
               <p class="qodef-m-artist-content-description"><?=$collectionDetails['collection_description'];?></p>
            </div>
            <img src="<?=$BASE_URL;?>assets/site/images/sound_play.gif" id="audio_play" class="audio_play_image" >
            <div class="music-duration">
              <span id="currentMusicDuration">00:00</span> - <span id="totalMusicDuration">00:00</span>
            </div>
          </div>
          <div class="qodef-m-tracks-list-item sound-filter">
            <div class="form-group">
              <input type="hidden" id="collection_id" name="collection_id" value="<?=$collectionId;?>" >
              <select id="sound_type" name="sound_type" class="form-control" style="width: 220px;" onchange="fetch_sound_list();" >
                <option value="" > Select Sound Type</option>
                <option value="1" <?=($selectedSound == 1) ? 'selected':'';?> > MP3 </option>
                <option value="2" <?=($selectedSound == 2) ? 'selected':'';?> > WAV </option>
                <option value="3" <?=($selectedSound == 3) ? 'selected':'';?> > STEM </option>
              </select>
            </div>
          </div>
          <div class="sound_details">
          <div class="qodef-m-tracks-list-item qodef-e qodef--free-download down_222" data-track-id="19" data-track-index="0">
            <div class="qodef-e-spinner">
              <span class="qodef-icon-linea-icons icon-music-record qodef-e-spinner-icon"></span> 
            </div>

            <div class="qodef-e-heading">
              <h5 class="qodef-e-heading-title" title="Click to play">
                <span class="qodef-e-heading-title-label">Sound</span>
              </h5>
            </div>
            <div class="qodef-e-action">
              <a class="qodef-e-action-control qodef--free-download" style="width: 180px;margin-left:50px; " href="#" target="_self" title="Free Download" >Key
              </a>

              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                BMP
              </a>
              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                Credit
              </a>
              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
              </a>
              <!-- <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
              </a> -->

              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                Download
              </a>

            </div>
          </div>
          <div id="dynamic-sound-div">
            <?php
              foreach($collectionSounds as $serialNumber => $collectionSound){
                $soundTags = explode(",", $collectionSound['sound_tags']);
            ?>
                <div class="sound_div">
                  <input type="hidden" id="collection_id_input" value="0" />
                  <div class="qodef-m-tracks-list-item qodef-e qodef--free-download" data-track-id="19" data-track-index="0">
                    <div class="qodef-e-spinner">
                      <audio controls id="audio_<?=$collectionSound['id'];?>" style="display:none;" class="audio" ontimeupdate="update_time(this.currentTime, this.duration);" onended="pause_all();" >
                        <source src="" type="audio/mpeg">
                        Your browser does not support the audio element.
                      </audio>
                      <div class="play-pause-div">
                        <?php
                          if($collectionSound['sound_type'] == 3){
                        ?>
                            <a class="qodef--play stem_button" href="javascript:void(0);" >
                              <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                            </a>
                        <?php
                          }else{
                        ?>
                            <a class="qodef--play play_pause_btn" href="javascript:void(0);" data-toggle="tooltip" title="Click to play" id="play_pause_btn_<?=$collectionSound['id'];?>" >
                              <i class="fa fa-spin fa-spinner" aria-hidden="true" style="font-size:45px; color:white;" ></i>
                            </a>
                            <a class="qodef-e-action-control qodef--play play_btn" href="javascript:void(0);" data-toggle="tooltip" title="Click to play" onclick="play(<?=$collectionSound['id'];?>);" id="play_btn_<?=$collectionSound['id'];?>" class="play_btn" >
                              <i class="fa fa-play" aria-hidden="true" ></i>
                            </a>
                            <a class="pause_btn" href="javascript:void(0);" data-toggle="tooltip" title="Click to Pause" onclick="pause(<?=$collectionSound['id'];?>);" id="pause_btn_<?=$collectionSound['id'];?>" >
                              <i class="fa fa-pause" aria-hidden="true" ></i>
                            </a>
                        <?php
                          }
                        ?>
                        <img class="sound-artwork" src="<?=$BASE_URL .$collectionSound['sound_artwork'];?>" >
                      </div>
                    </div>
                    <div class="qodef-e-heading">
                      <h5 class="qodef-e-heading-title" title="Click to play">
                        <span class="qodef-e-heading-title-label"><?=$collectionSound['sound_title'];?></span>
                      </h5>
                      <?php
                        foreach($soundTags as $soundTag){
                      ?>
                          <span class="qodef-e-heading-info"><?=trim($soundTag);?></span>
                      <?php
                        }
                      ?>
                    </div>
                    <div class="qodef-e-action">
                      <a class="qodef-e-action-control qodef--play" style="width: 180px;" href="#" target="_self" title="Click to play">
                        <?=$collectionSound['sound_key'];?>
                      </a>
                      <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                        <?=$collectionSound['sound_bpm'];?>
                      </a>
                      <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                        <?=$collectionSound['credit_amount'];?>
                      </a>
                      <?php
                        if(isset($collectionSound['is_liked'])){
                          $likeClass = ($collectionSound['is_liked'] == 1) ? 'fa-heart' : 'fa-heart-o';
                      ?>
                          <a class="qodef-e-action-control qodef--play" onclick="like_dislike(<?=$collectionSound['id'];?>);" href="javascript:void(0);" title="Click to Like / Dislike" id="like_dislike_<?=$collectionSound['id'];?>" >
                            <i class="fa <?=$likeClass;?>" aria-hidden="true"></i>
                          </a>
                      <?php
                        }else{
                      ?>
                          <a class="qodef-e-action-control qodef--play" href="#" data-toggle="modal" data-target="#loginModal" title="Login">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                          </a>
                      <?php
                        }
                      ?>
                      <?php
                        if(isset($collectionSound['is_downloaded'])){
                          if($collectionSound['is_downloaded'] == 1){
                      ?>
                            <a class="qodef-e-action-control qodef--play" href="javascript:void(0);" target="_self" title="Downloaded" >
                              <i class="fa fa-check-circle" aria-hidden="true"></i>
                            </a>
                      <?php
                          }else{
                      ?>
                            <a class="qodef-e-action-control qodef--play" onclick="download_sound(<?=$collectionSound['id'];?>);" href="javascript:void(0);" target="_self" title="Cost you <?=$collectionSound['credit_amount'];?> credits" id="download_btn_<?=$collectionSound['id'];?>" >
                              <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                            </a>
                      <?php
                          }
                      ?>
                      <?php
                        }else{
                      ?>
                          <a class="qodef-e-action-control qodef--play" href="#" data-toggle="modal" data-target="#loginModal" title="Login">
                            <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                          </a>
                      <?php
                        }
                      ?>
                    </div>
                  </div>

                  <div class="decs">
                    <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                      <?=substr(strip_tags($collectionSound['sound_description']), 0, 200);?>
                    </a>
                  </div>

                </div>
            <?php
              }
            ?>
            <?php
              if(!count($collectionSounds)){
            ?>
                <div class="sound_div">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="text-center">
                        <img src="<?=$BASE_URL;?>assets/site/images/music_icon.png" >
                      </div>
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

      <div class="col-md-4 ftco-animate fadeInUp ftco-animated details_new">
        <h2 class="mb-2"><?=$collectionDetails['collection_name'];?></h2>
        <p><?=$collectionDetails['collection_description'];?></p>

        <?php
          if(!empty($userdata)){
        ?>
            <?php
              if($creditAvailable){
            ?>
              <?php
                if($totalCredits && !$downloaded){
              ?>
                  <a href="javascript:void(0);" onclick="download_collection(<?=$collectionId;?>);" class="btn pricing-plan-purchase-btn download" data-toggle="tooltip" title="Will cost you <?=$totalCredits;?> credits" >Download Now</a>
              <?php
                }else{
              ?>
                  <a href="javascript:void(0);" class="btn pricing-plan-purchase-btn download" disabled data-toggle="tooltip" title="Will cost you <?=$totalCredits;?> credits" > Downloaded &nbsp <i class="fa fa-check-circle" aria-hidden="true"></i> </a>
              <?php
                }
              ?>
            <?php
              }else{
            ?>
                <a href="<?=site_url('Plan');?>" class="btn pricing-plan-purchase-btn download" title="Will cost you <?=$totalCredits;?> credits" > Download Now</a>
            <?php
              }
            ?>
        <?php
          }else{
        ?>
            <a href="#" data-toggle="modal" data-target="#loginModal" class="btn pricing-plan-purchase-btn download">Download Now</a>
        <?php
          }
        ?>
        <div class="tag-widget post-tag-container mb-5 mt-5">
          <div class="tagcloud">
            <?php
              foreach($sliderCollections as $sliderCollection){
                if($collectionDetails['id'] == $sliderCollection['id']) continue;
            ?>
                <a href="<?=$BASE_URL .'Collections/' .$sliderCollection['id'];?>" class="tag-cloud-link"><?=$sliderCollection['collection_name'];?></a>
            <?php
              }
            ?>
          </div>
        </div>
        <div id="responseMessage"></div>
        <?=$this->session->flashdata('responseMessage');?>
      </div>
    </div>
  </div>
</section>

<?php
  if(count($sliderCollections)){
?>
    <section class="ftco-section ftco-destination" style="padding: 3em 0 0;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12 ftco-animate ">
            <h2>People also viewed these collections </h2>
            <span class="subheading mb-4" style="width: 100%;">Lorem Ipsum rhis ts toshhoop svetsgin. Proin gravida nibh lorem quis bibendum aucto bibendum aucto </span>
          </div>
        </div>

        <div class="row justify-content-center community">
          <div class="col-md-12">
            <div class="sounds-slider owl-carousel ftco-animate">
              <?php
                foreach($sliderCollections as $sliderCollection){
              ?>
                  <div class="item">
                    <div class="destination">
                      <a href="<?=$BASE_URL .'Collection-Details/' .$sliderCollection['id'];?>" class="img d-flex justify-content-center align-items-center" style="background-image: url(<?=$BASE_URL .$sliderCollection['collection_icon'];?>);">
                        <div class="icon d-flex justify-content-center align-items-center">
                          <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                        </div>
                      </a>
                      <div class="text p-3">
                        <h3><a href="<?=$BASE_URL .'Collection-Details/' .$sliderCollection['id'];?>"><?=$sliderCollection['collection_name'];?></a></h3>
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
  }
?>

<section id="music-player" class="player_design"></section>

<?php
  include_once'include/footer.php';
?>

<script src="<?=site_url('assets/site/js/preview.js?time=' .time());?>"></script>

<script>
  <?php
    if($selectedSound){
  ?>
      fetch_sound_list();
  <?php
    }
  ?>
</script>