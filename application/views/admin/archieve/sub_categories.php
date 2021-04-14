<?php
  foreach($subCategories as $subCategory){
?>
    <option value="<?=$subCategory['id'];?>"><?=$subCategory['name'];?></option>
<?php
  }
?>
<?php
  if(!count($subCategories)){
?>
    <option value="">No Category Found!!</option>
<?php
  }
?>