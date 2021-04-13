<?php
include_once'include/header.php';
?>

<style>
  .pause_btn, #audio_play, .music-duration{
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
</style>

<section class="ftco-section ftco-counter img img_counter2" id="section-counter" style="background-image: url(<?=$BASE_URL;?>assets/site/images/back.jpg);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
        <h2 class="mb-4 community_heading"><?=$parentCategoryDetails['name'];?></h2>
        <span class="subheading"><?=$parentCategoryDetails['description'];?></span>
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
          <!--
          <div id="qodef-m-track-player-552" class="qodef-m-track-player" style="width: 0px; height: 0px;">
            <img id="jp_poster_1" style="width: 0px; height: 0px; display: none;">
            <audio id="jp_audio_1" preload="metadata" src="https://neobeat.qodeinteractive.com/wp-content/uploads/2020/02/Black-Hole-Sun.mp3" title="Black Hole Sun"></audio>
          </div>
          -->
          <div class="qodef-m-artist" style="background-image: url('<?=$BASE_URL;?>assets/site/images/img2.jpg')">
            <img src="<?=$BASE_URL .$categoryDetails['icon'];?>" class="qodef-m-artist-image" alt="v" srcset="<?=$BASE_URL .$categoryDetails['icon'];?>" sizes="(max-width: 280px) 100vw, 280px" width="280" height="280"> 
            <div class="qodef-m-artist-content">
               <h4 itemprop="author" class="qodef-m-artist-content-name"><?=$categoryDetails['name'];?></h4>
               <p class="qodef-m-artist-content-description"><?=$categoryDetails['description'];?></p>
            </div>
            <img src="<?=$BASE_URL;?>assets/site/images/sound_play.gif" id="audio_play" class="audio_play_image" >
            <div class="music-duration">
              <span id="currentMusicDuration">00:00</span> - <span id="totalMusicDuration">00:00</span>
            </div>
          </div>
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
              <a class="qodef-e-action-control qodef--free-download" style="width: 180px;" href="#" target="_self" title="Free Download" >Key
              </a>
              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                BMP
              </a>
              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                Credit
              </a>
              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
              </a>
              <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
              </a>
            </div>
          </div>

          <?php
            foreach($categorySounds as $serialNumber => $categorySound){
              $soundTags = explode(",", $categorySound['sound_tags']);
          ?>
              <div class="sound_div">
              <div class="qodef-m-tracks-list-item qodef-e qodef--free-download" data-track-id="19" data-track-index="0">
                <div class="qodef-e-spinner">
                  <audio controls id="audio_<?=$categorySound['id'];?>" style="display:none;" class="audio" ontimeupdate="update_time(this.currentTime, this.duration);" onended="pause_all();" >
                    <source src="horse.ogg" type="audio/ogg">
                    <source src="<?=site_url($categorySound['sound_file']);?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                  </audio>
                  <?php
                    if($categorySound['sound_type'] == 3){
                  ?>
                      <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                      <img src="<?=$BASE_URL .$categorySound['sound_artwork'];?>" width="100" >
                  <?php
                    }else{
                  ?>
                      <div class="play-pause-div">
                        <a class="qodef-e-action-control qodef--play play_btn" href="javascript:void(0);" data-toggle="tooltip" title="Click to play" onclick="play(<?=$categorySound['id'];?>);" id="play_btn_<?=$categorySound['id'];?>" class="play_btn" >
                          <i class="fa fa-play" aria-hidden="true" ></i>
                        </a>
                        <a class="pause_btn" href="javascript:void(0);" data-toggle="tooltip" title="Click to Pause" onclick="pause(<?=$categorySound['id'];?>);" id="pause_btn_<?=$categorySound['id'];?>" >
                          <i class="fa fa-pause" aria-hidden="true" ></i>
                        </a>
                        <img class="sound-artwork" src="<?=$BASE_URL .$categorySound['sound_artwork'];?>" >
                      </div>
                  <?php
                    }
                  ?>
                </div>
                <div class="qodef-e-heading">
                  <h5 class="qodef-e-heading-title" title="Click to play">
                    <span class="qodef-e-heading-title-label"><?=$categorySound['sound_title'];?></span>
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
                    <?=$categorySound['sound_key'];?>
                  </a>
                  <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                    <?=$categorySound['sound_bpm'];?>
                  </a>
                  <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                    <?=$categorySound['credit_amount'];?>
                  </a>
                  <?php
                    if(isset($categorySound['is_liked'])){
                      $likeClass = ($categorySound['is_liked'] == 1) ? 'fa-heart' : 'fa-heart-o';
                  ?>
                      <a class="qodef-e-action-control qodef--play" onclick="like_dislike(<?=$categorySound['id'];?>);" href="javascript:void(0);" title="Click to Like / Dislike" id="like_dislike_<?=$categorySound['id'];?>" >
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
                    if(!empty($userdata)){
                  ?>
                      <a href="<?=site_url($categorySound['sound_file']);?>" style="display:none;" id="download_<?=$categorySound['id'];?>" download >Download</a>
                      <a class="qodef-e-action-control qodef--play" onclick="download_file(<?=$categorySound['id'];?>);" href="javascript:void(0);" title="Click to play">
                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                      </a>
                  <?php
                    }else{
                  ?>
                      <a class="qodef-e-action-control qodef--play" href="javascript:void(0);" data-toggle="modal" data-target="#loginModal" >
                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                      </a>
                  <?php
                    }
                  ?>
                </div>
              </div>

              <div class="decs">
                <a class="qodef-e-action-control qodef--play" href="#" target="_self" title="Click to play">
                    <?=substr(strip_tags($categorySound['sound_description']), 0, 200);?>
                  </a>
              </div>

              </div>
          <?php
            }
          ?>
          <?php
            if(!count($categorySounds)){
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

      <div class="col-md-4 ftco-animate fadeInUp ftco-animated details_new">
        <h2 class="mb-2"><?=$categoryDetails['name'];?></h2>
        <p><?=$categoryDetails['description'];?></p>

        <?php
          if(!empty($userdata)){
        ?>
            <a href="javascript:void(0);" onclick="download_sub_category(<?=$subCategoryId;?>);" class="btn pricing-plan-purchase-btn download">Download Now</a>
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
              foreach($categories as $category){
                if($parentCategoryDetails['id'] == $category['id']) continue;
            ?>
                <a href="<?=$BASE_URL .'Sounds/' .$category['id'];?>" class="tag-cloud-link"><?=$category['name'];?></a>
            <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="ftco-section ftco-destination" style="padding: 3em 0 0;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 ftco-animate ">
      <h2>People also viewed these packs </h2>
      <span class="subheading mb-4" style="width: 100%;">Lorem Ipsum rhis ts toshhoop svetsgin. Proin gravida nibh lorem quis bibendum aucto bibendum aucto </span>
      </div>
    </div>

    <div class="row justify-content-center community">
      <div class="col-md-12">
        <div class="sounds-slider owl-carousel ftco-animate">
          <?php
            foreach($sliderSubCategories as $sliderSubCategory){
          ?>
              <div class="item">
                <div class="destination">
                  <a href="<?=$BASE_URL .'Sound-Details/' .$sliderSubCategory['id'];?>" class="img d-flex justify-content-center align-items-center" style="background-image: url(<?=$BASE_URL .$sliderSubCategory['icon'];?>);">
                    <div class="icon d-flex justify-content-center align-items-center">
                      <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                    </div>
                  </a>
                  <div class="text p-3">
                    <h3><a href="<?=$BASE_URL .'Sound-Details/' .$sliderSubCategory['id'];?>"><?=$sliderSubCategory['name'];?></a></h3>
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


<!-- Modal -->
<div id="downloadSoundModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="downloadSoundForm" name="downloadSoundForm" method="POST" onsubmit="download_sound(event);" >
      <input type="hidden" name="sound" id="download_sound_id" >
      <input type="hidden" name="category" id="download_category_id" >
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Download Sound</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="edit-modal-body" > </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-submit" > Agree & Download </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>


<?php
include_once'include/footer.php';
?>

<script>
  function play(sound_id){
    pause_all();
    $("#audio_" + sound_id).get(0).play();
    $("#audio_play").show();
    $("#play_btn_" + sound_id).hide();
    $("#pause_btn_" + sound_id).show();
    $("#pause_btn_" + sound_id).addClass('qodef-e-action-control qodef--play');
  }

  function pause(sound_id){
    $("#audio_" + sound_id).get(0).pause();
    $("#pause_btn_" + sound_id).hide();
    $("#play_btn_" + sound_id).show();
    $("#audio_play").hide();
  }

  function pause_all(){
    $(".audio").get(0).pause();
    $(".pause_btn").removeClass('qodef-e-action-control qodef--play');
    $(".pause_btn").hide();
    $(".play_btn").show();
    $("#audio_play").hide();
  }

  function update_time(current_time, audio_duration){
    $("#currentMusicDuration").html(current_time.toFixed(2));
    $("#totalMusicDuration").html(audio_duration.toFixed(2));
  }

  function download_file(sound_id){
    $.ajax({
      type: "POST",
      // dataType: 'json',
      dataType: 'html',
      url: site_url + 'Download',
      data: {
        'sound_id' : sound_id
      },
      beforeSend: function () {
        $("#edit-modal-body").html("");
        $('#downloadSoundModal').modal('show');
        $('#downloadSoundModal').addClass('text-center');
        $("#edit-modal-body").html('<i style="font-size: 50px;" class="fa fa-spin fa-spinner"></i>');
      },
      success: function (response) {
        // alert(response.file);
        // window.location = response.file;
        $('#downloadSoundModal').removeClass('text-center');
        $("#edit-modal-body").html("");
        $("#edit-modal-body").html(response);
        $("#download_sound_id").val(sound_id);
      }
    })
  }

  function download_sub_category(category_id){
    $.ajax({
      type: "POST",
      dataType: 'html',
      url: site_url + 'Download/Bulk',
      data: {
        'category_id' : category_id
      },
      beforeSend: function () {
        $("#edit-modal-body").html("");
        $('#downloadSoundModal').modal('show');
        $('#downloadSoundModal').addClass('text-center');
        $("#edit-modal-body").html('<i style="font-size: 50px;" class="fa fa-spin fa-spinner"></i>');
      },
      success: function (response) {
        $('#downloadSoundModal').removeClass('text-center');
        $("#edit-modal-body").html("");
        $("#edit-modal-body").html(response);
        $("#download_category_id").val(category_id);
      }
    })
  }

  function download_sound(e){
    e.preventDefault();
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: site_url + 'Download/Pay',
      data: new FormData($('#downloadSoundForm')[0]),
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function () {
        $(".btn-submit").prop('disabled', true);
        $(".btn-submit").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      },
      success: function (response) {
        $(".btn-submit").prop('disabled', false);
        $(".btn-submit").html('Agree & Download');
        $("#responseMessage").html(response.responseMessage);
      }
    })
  }

</script>