<?php
  foreach($collectionSounds as $serialNumber => $collectionSound){
    $soundTags = explode(",", $collectionSound['sound_tags']);
?>
    <div class="sound_div">
      <input type="hidden" id="collection_id_input" value="<?=$collection_sound_type;?>" />
      <div class="qodef-m-tracks-list-item qodef-e qodef--free-download" data-track-id="19" data-track-index="0">
        <div class="qodef-e-spinner">
          <audio controls id="audio_<?=$collectionSound['id'];?>" style="display:none;" class="audio" ontimeupdate="update_time(this.currentTime, this.duration);" onended="pause_all();" >
            <source src="horse.ogg" type="audio/ogg">
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
          <img class="sound-artwork" src="<?=site_url($collectionSound['sound_artwork']);?>" >
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
            <img src="<?=site_url();?>assets/site/images/music_icon.png" >
          </div>
        </div>
      </div>
    </div>
<?php
  }
?>