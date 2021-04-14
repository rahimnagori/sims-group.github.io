<div class="form-group">
  <label> Banner Heading </label>
  <input type="text" class="form-control" required name="heading" value="<?=$bannerDetails['heading']?>" >
  <input type="hidden" required name="banner_id" value="<?=$bannerDetails['id']?>" >
</div>

<div class="form-group">
  <label> Banner Description </label>
  <textarea class="form-control" required name="description"><?=$bannerDetails['description'];?></textarea>
</div>

<div class="form-group">
  <label> Collection </label>
  <select name="collection_id" class="form-control" onchange="get_sub_sounds(this.value, 'edit_sounds_input');" required >
    <option value="">Select a Collection</option>
    <?php
      foreach($collections as $collection){
    ?>
        <option value="<?=$collection['id'];?>" <?=($bannerDetails['collection_id'] == $collection['id']) ? 'selected' : '';?> ><?=$collection['collection_name'];?></option>
    <?php
      }
    ?>
  </select>
</div>

<div class="form-group" id="sub_categories">
  <label> Banner Sound </label>
  <select name="sound_id" class="form-control" id="edit_sounds_input" required >
    <?php
      foreach($collectionSounds as $collectionSound){
    ?>
        <option value="<?=$collectionSound['id'];?>" <?=($bannerDetails['sound_id'] == $collectionSound['id']) ? 'selected' : '';?> ><?=$collectionSound['sound_title'];?></option>
    <?php
      }
    ?>
  </select>
</div>

<div class="form-group">
  <label> Banner Image </label>
  <input type="file" accept="image/*" name="banner_image" onchange="preview_image(this, 'edit_preview_image');" >
  <img id="edit_preview_image" src="<?=site_url($bannerDetails['banner_image']);?>" width="100" > 
  <input type="hidden" required name="banner_image_old" value="<?=$bannerDetails['banner_image']?>" >
</div>

<div id="editResponseMessage"></div>