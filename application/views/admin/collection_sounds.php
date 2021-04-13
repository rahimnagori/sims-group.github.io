<?php
  foreach($sounds as $sound){
?>
    <option value="<?=$sound['id'];?>"><?=$sound['sound_title'];?></option>
<?php
  }
?>
<?php
  if(!count($sounds)){
?>
    <option value="">No Category Found!!</option>
<?php
  }
?>