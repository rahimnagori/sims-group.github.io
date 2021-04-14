<style>
.sound-tags .bootstrap-tagsinput {
  width: 100%;
  border-radius: 0 !important;
  box-shadow: none !important;
  padding: 7px;
}
.sound-tags .label {
  font-size: 14px;
}
.sound-file {
  border: 1px solid #e1e1e1;
  padding: 5px;
  position: relative;
  margin-bottom: 10px;
  padding-right: 40px;
}
.icon-remove {
  position: absolute;
  right: 0;
  top: 0;
}
.sound-file input{
  width: 100%;
}
.sound-file .row {
  margin: 0px -5px;
}
.sound-file .row .col-md-4{
  padding: 0px 5px;
}
</style>

<link rel="stylesheet" href="<?=site_url('assets/site/css/bootstrap-tagsinput.css');?>">

<div class="form-group">
  <label> Name </label>
  <input type="text" class="form-control" required name="collection_name" value="<?=$collectionDetails['collection_name'];?>" >
  <input type="hidden" required name="collection_id" value="<?=$collectionDetails['id'];?>" >
</div>

<div class="form-group">
  <label> Description </label>
  <textarea class="form-control" id="edit-description" required name="collection_description" ><?=$collectionDetails['collection_description'];?></textarea>
</div>

<div class="form-group">
  <label> Image </label>
  <input type="file" accept="image/*" name="icon_update" onchange="preview_image(this, 'edit_preview_image');" >
  <input type="hidden" name="icon_old" value="<?=$collectionDetails['collection_icon'];?>" >
  <img id="edit_preview_image" src="<?=site_url($collectionDetails['collection_icon']);?>" width="100" >
</div>

<div class="form-group">
  <label> Sound Genre </label>
  <select name="sound_category" class="form-control" onchange="get_sub_categories(this.value, 'sub_categories_input_new');" required >
    <option value="">Select a Genre</option>
    <?php
      foreach($categories as $category){
    ?>
        <option value="<?=$category['id'];?>" <?=($soundDetails['sound_category'] == $category['id']) ? 'selected' : '';?> ><?=$category['name'];?></option>
    <?php
      }
    ?>
  </select>
</div>

<div class="form-group" id="sub_categories">
  <label> Sound Sub Genre </label>
  <select name="sound_sub_category" class="form-control" id="sub_categories_input_new" required >
    <?php
      foreach($subCategories as $subCategory){
    ?>
        <option value="<?=$subCategory['id'];?>" <?=($soundDetails['sound_sub_category'] == $subCategory['id']) ? 'selected' : '';?> ><?=$subCategory['name'];?></option>
    <?php
      }
    ?>
  </select>
</div>

<div class="form-group sound-tags">
  <label> Sound Tags </label>
  <input type="text" class="form-control" required name="sound_tags" data-role="tagsinput" value="<?=$soundDetails['sound_tags'];?>" >
</div>

<div class="form-group">
  <label> Sound Artwork </label>
  <input type="file" accept="image/*" name="sound_artwork" onchange="preview_image(this, 'edit_preview_artwork');"  >
  <img id="edit_preview_artwork" width="100" src="<?=site_url($soundDetails['sound_artwork']);?>" > 
</div>

<div class="form-group sound-tags">
  <label> MP3 </label>
  <input type="checkbox" name="mp3" value="edit_mp3_sound_section" onchange="show_hide_sound_section(this.value, this.checked, this.name);" <?=($mp3) ? 'checked' : '';?> >
  <label> WAV </label>
  <input type="checkbox" name="wav" value="edit_wav_sound_section" onchange="show_hide_sound_section(this.value, this.checked, this.name);" <?=($wav) ? 'checked' : '';?>  >
  <label> STEM (ZIP) </label>
  <input type="checkbox" name="stem" value="edit_stem_sound_section" onchange="show_hide_sound_section(this.value, this.checked, this.name);" <?=($stem) ? 'checked' : '';?>  >
  <p class="text-danger" id="edit_file_type_error">Please select atleast one file type.</p>
</div>
<div class="sound-section" id="edit_mp3_sound_section" style="<?=($mp3) ? 'display:block;' : '';?>" >
  <label>MP3</label>
  <?php
    foreach($mp3CollectionSounds as $serialNumber => $mp3CollectionSound){
      $divStyle = 'style="display:block;"';
      // $divStyle = '';
      $deleteButtonStyle = (count($mp3CollectionSounds) != $serialNumber + 1) ? 'style="display:inline-block;"' : 'style="display:none;"';
      // $deleteButtonStyle = '';
      $addButtonStyle = (count($mp3CollectionSounds) != $serialNumber + 1) ? 'style="display:none;"' : 'style="display:inline-block;"';
      // $addButtonStyle = '';
  ?>
      <div class="sound-file" id="mp3-edit-sound-file-<?=$serialNumber + 1;?>">
        <div class="row">
          <div class="col-md-3">
            <input type="file" name="mp3_file[]" id="edit_mp3_file_<?=$serialNumber + 1;?>" onchange="edit_show_add_more('mp3', <?=$serialNumber + 2;?>);" accept="audio/mp3" >
            <input type="hidden" name="mp3_old_file[]" value="<?=$mp3CollectionSound['sound_file'];?>">
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="number" class="form-control" name="mp3_sound_bpm[]" step="1" placeholder="BPM" id="mp3_sound_bpm_input_<?=$serialNumber + 1;?>" value="<?=$mp3CollectionSound['sound_bpm'];?>" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="text" class="form-control" name="mp3_sound_key[]" placeholder="Key" id="mp3_sound_key_input_<?=$serialNumber + 1;?>" value="<?=$mp3CollectionSound['sound_key'];?>" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="number" class="form-control" required name="mp3_credit_amount[]" step="0.01" id="mp3_credit_amount_input_<?=$serialNumber + 1;?>" placeholder="Credit" value="<?=$mp3CollectionSound['credit_amount'];?>" >
              <input type="hidden" required name="update_mp3_sound_id[]" value="<?=$mp3CollectionSound['id'];?>" >
            </div>
          </div>
        </div>
        <div class="icon-remove" <?=$divStyle;?> id="edit-icon-remove-mp3-<?=$serialNumber + 1;?>" >
          <button type="button" class="btn add-btn" <?=$addButtonStyle;?> onclick="edit_add_more('mp3', '<?=$serialNumber + 1;?>');" id="mp3-edit-btn-<?=$serialNumber + 1;?>" >
            <i class="fa fa-plus" aria-hidden="true"></i>
          </button>
          <button type="button" class="btn delete-btn" <?=$deleteButtonStyle;?> onclick="edit_delete_file('mp3', '<?=$serialNumber + 2;?>');" id="mp3-edit-delete-btn-<?=$serialNumber + 1;?>" >
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
      </div>
  <?php
    }
  ?>
</div>
<div class="sound-section" id="edit_wav_sound_section" style="<?=($wav) ? 'display:block;' : '';?>" >
  <label>WAV</label>
  <?php
    foreach($wavCollectionSounds as $serialNumber => $wavCollectionSound){
      $divStyle = 'style="display:block;"';
      $deleteButtonStyle = (count($wavCollectionSounds) != $serialNumber + 1) ? 'style="display:inline-block;"' : 'style="display:none;"';
      $addButtonStyle = (count($wavCollectionSounds) != $serialNumber + 1) ? 'style="display:none;"' : 'style="display:inline-block;"';
  ?>
      <div class="sound-file" id="wav-edit-sound-file-<?=$serialNumber + 1;?>">
        <div class="row">
          <div class="col-md-3">
            <input type="file" name="wav_file[]" id="edit_wav_file_<?=$serialNumber + 1;?>" onchange="edit_show_add_more('wav', <?=$serialNumber + 2;?>);" accept="audio/wav" >
            <input type="hidden" name="wav_old_file[]" value="<?=$wavCollectionSound['sound_file'];?>">
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="number" class="form-control" name="wav_sound_bpm[]" step="1" placeholder="BPM" value="<?=$wavCollectionSound['sound_bpm'];?>" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="text" class="form-control" name="wav_sound_key[]" placeholder="Key" value="<?=$wavCollectionSound['sound_key'];?>" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="number" class="form-control" required name="wav_credit_amount[]" step="0.01" id="wav_credit_amount_input_<?=$serialNumber + 1;?>" placeholder="Credit" value="<?=$wavCollectionSound['credit_amount'];?>" >
              <input type="hidden" required name="update_wav_sound_id[]" value="<?=$wavCollectionSound['id'];?>" >
            </div>
          </div>
        </div>
        <div class="icon-remove" <?=$divStyle;?> id="edit-icon-remove-wav-<?=$serialNumber + 1;?>" >
          <button type="button" class="btn add-btn" <?=$addButtonStyle;?> onclick="edit_add_more('wav', '<?=$serialNumber + 1;?>');" id="wav-edit-btn-<?=$serialNumber + 1;?>" >
            <i class="fa fa-plus" aria-hidden="true"></i>
          </button>
          <button type="button" class="btn delete-btn" <?=$deleteButtonStyle;?> onclick="edit_delete_file('wav', '<?=$serialNumber + 2;?>');" id="wav-edit-delete-btn-<?=$serialNumber + 1;?>" >
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
      </div>
  <?php
    }
  ?>
</div>
<div class="sound-section" id="edit_stem_sound_section" style="<?=($stem) ? 'display:block;' : '';?>" >
  <label>STEM(ZIP)</label>
  <?php
    foreach($stemCollectionSounds as $serialNumber => $stemCollectionSound){
      $divStyle = 'style="display:block;"';
      $deleteButtonStyle = (count($stemCollectionSounds) != $serialNumber + 1) ? 'style="display:inline-block;"' : 'style="display:none;"';
      $addButtonStyle = (count($stemCollectionSounds) != $serialNumber + 1) ? 'style="display:none;"' : 'style="display:inline-block;"';
  ?>
      <div class="sound-file" id="stem-edit-sound-file-<?=$serialNumber + 1;?>">
        <div class="row">
          <div class="col-md-3">
            <input type="file" name="stem_file[]" id="edit_stem_file_<?=$serialNumber + 1;?>" onchange="edit_show_add_more('stem', <?=$serialNumber + 2;?>);" accept=".zip, .rar" >
            <input type="hidden" name="stem_old_file[]" value="<?=$stemCollectionSound['sound_file'];?>">
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="number" class="form-control" name="stem_sound_bpm[]" step="1" placeholder="BPM" value="<?=$stemCollectionSound['sound_bpm'];?>" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="text" class="form-control" name="stem_sound_key[]" placeholder="Key" value="<?=$stemCollectionSound['sound_key'];?>" >
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <input type="number" class="form-control" required name="stem_credit_amount[]" step="0.01" id="stem_credit_amount_input_<?=$serialNumber + 1;?>" placeholder="Credit" value="<?=$stemCollectionSound['credit_amount'];?>" >
              <input type="hidden" required name="update_stem_sound_id[]" value="<?=$stemCollectionSound['id'];?>" >
            </div>
          </div>
        </div>
        <div class="icon-remove" <?=$divStyle;?> id="edit-icon-remove-stem-<?=$serialNumber + 1;?>" >
          <button type="button" class="btn add-btn" <?=$addButtonStyle;?> onclick="edit_add_more('stem', '<?=$serialNumber + 1;?>');" id="stem-edit-btn-<?=$serialNumber + 1;?>" >
            <i class="fa fa-plus" aria-hidden="true"></i>
          </button>
          <button type="button" class="btn delete-btn" <?=$deleteButtonStyle;?> onclick="edit_delete_file('stem', '<?=$serialNumber + 2;?>');" id="stem-edit-delete-btn-<?=$serialNumber + 1;?>" >
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
      </div>
  <?php
    }
  ?>
</div>
<p class="text-danger" id="minimum_file_error">Please select atleast one file.</p>

<div id="editResponseMessage"></div>

<script src="<?=base_url('assets/site/js/bootstrap-tagsinput.js');?>"></script>