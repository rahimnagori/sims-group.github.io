<?php
  // include_once'include/header.php';
?>
<!--
<link rel="stylesheet" href="<?=site_url();?>assets/site/css/player.css?time=<?=time(); ?>">
-->
<style>
  #pause{
    display:none;
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css"/>

<div class="bg-container" style="" >
  <img src="" alt="" id="background">
</div>
<div class="player-container">
  <!-- Song -->
  <div class="img-container">
    <img src="" alt="" id="cover" class="active">
  </div>
  <h2 id="title_old"></h2>
  <audio src=""></audio>
  <!-- Controls -->
  <!--
  <div class="player-controls">
    <i class="fas fa-backward" title="Previous"></i>
    <i class="fas fa-play main-button" title="Play"></i>
    <i class="fas fa-forward" title="Next"></i>
  </div>
  -->
</div>
<div class="player">
  <div class="player-heading">
    <a href="<?=site_url('Collection-Details/' .$sound_collection_id);?>" id="player-heading" ><h4 class="player-track-title jp-title" id="title" ></h4></a>
  </div>

  <div class="qodef-m-player-middle">
    <div class="qodef-m-track-progress jp-gui jp-interface">
      <div class="jp-progress">
        <div class="jp-seek-bar" id="progress-container" >
          <div class="jp-play-bar" id="progress"></div>
        </div>
      </div>
    </div>

    <div class="qodef-m-track-time jp-gui jp-interface">
      <span class="qodef-m-track-time-current jp-current-time" id="current-time" >00:00</span>/<span class="qodef-m-track-time-duration jp-duration" id="duration" >00:00</span>
    </div>

    <div class="qodef-m-player-controls jp-gui jp-interface">
      <ul class="jp-controls">
        <li>
          <a class="jp-previous" id="prev" >
            <i class="fa fa-arrow-left" aria-hidden="true"></i>
          </a>
        </li>
        <li>
          <a class="jp-play" id="play" >
            <i class="fa fa-play" aria-hidden="true" id="play_pause_icon" ></i>
          </a>
        </li>
        <li>
          <a class="jp-next" id="next">
            <i class="fa fa-arrow-right" aria-hidden="true"></i>
          </a>
        </li>
      </ul>
    </div>

    <div class="qodef-m-volume-control jp-gui jp-interface">
      <div class="jp-volume-controls">
        <a class="jp-mute">
          <i class="fa fa-volume-up" aria-hidden="true"></i>
        </a>
        <div class="jp-volume-bar">
          <div class="jp-volume-bar-value"></div>
          <input type="range" id="volume-control">
        </div>
      </div>
    </div>
  </div>
  <div class="qodef-m-player-footer"> <a itemprop="url" class="qodef-m-album-title" href="#" id="title-old"></a> </div>
</div>
<?php
  $songs = json_encode($collectionSounds);
?>

<?php
  // include_once'include/footer.php';
?>

<script>
  const songs = JSON.parse('<?=$songs;?>');
</script>

<script src="<?=site_url();?>assets/site/js/index-player.js?time=<?=time();?>" type="text/javascript"></script>