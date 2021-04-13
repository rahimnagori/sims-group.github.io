<?php include_once('include/header.php'); ?>

<style>
#addToolError, .editToolError, .delete-btn, .add-btn, .icon-remove, .sound-section, #file_type_error, #minimum_file_error, #max_file_warning_mp3, #max_file_warning_wav, #max_file_warning_stem, #edit_file_type_error{
  display:none;
}
.pac-container{
  z-index: 1051 !important;
}
.margin-top{
  margin-top: 2%;
}
.delete-filter-btn{
  display:none;
}
.custom-multiselect .btn-group.custom-btn {
  width: 100%;
}
.custom-multiselect .multiselect {
  width: 100% !important;
  border: 1px solid #E1E1E1;
  box-shadow: none !important;
  text-align: left;
}
.custom-multiselect .dropdown-menu {
  min-height: 100%;
  width: 100%;
}
.custom-multiselect .dropdown-menu > li > a{
  padding: 8px 30px;
}
.custom-multiselect .dropdown-menu label{
  margin: 0;
}
.custom-multiselect .dropdown-menu {
  min-height: 100%;
  width: 100%;
  height: 150px;
  overflow: auto;
}
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
.edit-add-button{
  top: 53px;
  position: absolute;
  right: 0px;
}
</style>
<link rel="stylesheet" href="<?=$BASE_URL; ?>assets/site/css/bootstrap-tagsinput.css">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Collections 
      <small>Management</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Collections Management</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?=$this->session->flashdata('responseMessage');?>
    <div id="featuredStatus"></div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <span class="font-weight-bold text-uppercase">Collections Management</span>
            <span class="pull-right" ><a href="#" class="btn btn-info" data-toggle="modal" data-target="#addCollectionModal" > Add Collection </a></span>
            <span class="pull-right" style="display:none;" ><a href="#" class="btn btn-info" data-toggle="modal" data-target="#addBulkSoundModal" > Add Collection </a></span>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="boottable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>S.NO.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Logo</th>
                    <th style="display:none;" >Featured</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach($collections as $serialNumber => $collection){
                  ?>
                      <tr>
                        <td><?=$serialNumber + 1; ?></td>
                        <td><?=$collection['collection_name'];?></td>
                        <td><?=$collection['collection_description'];?></td>
                        <td><img src="<?=site_url($collection['collection_icon']);?>" width="100" > </td>
                        <td style="display:none;">
                          <input type="checkbox" name="is_featured" id="is_featured_<?=$collection['id'];?>" <?=($collection['is_featured']) ? 'checked' : '';?> onchange="update_feature_category(<?=$collection['id'];?>);" > 
                        </td>
                        <td>
                          <button type="button" onclick="get_collection(<?=$collection['id'];?>);" class="btn btn-info btn-xs"> Edit </button>
                          <button type="button" onclick="delete_collection(<?=$collection['id'];?>);" class="btn btn-danger btn-xs"> Delete </button>
                        </td>
                      </tr>
                  <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div id="addCollectionModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="addCollectionForm" name="addCollectionForm" method="POST" onsubmit="add_collection_new(event);" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Collection</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label> Name </label>
            <input type="text" class="form-control" required name="collection_name" >
          </div>

          <div class="form-group">
            <label> Description </label>
            <textarea class="form-control" required name="collection_description"></textarea>
          </div>

          <div class="form-group">
            <label> Logo </label>
            <input type="file" required accept="image/*" name="collection_icon" onchange="preview_image(this, 'add_preview_image');" >
            <img id="add_preview_image" src="" width="100" >
          </div>

          <div class="form-group">
            <label> Sound Genre </label>
            <select name="sound_category" class="form-control" onchange="get_sub_categories(this.value, 'sub_categories_input_new');" required >
              <option value="">Select a Genre</option>
              <?php
                foreach($categories as $category){
              ?>
                  <option value="<?=$category['id'];?>"><?=$category['name'];?></option>
              <?php
                }
              ?>
            </select>
          </div>

          <div class="form-group" id="sub_categories">
            <label> Sound Sub Genre </label>
            <select name="sound_sub_category" class="form-control" id="sub_categories_input_new" required >
              <option value="0">Select a Genre First</option>
            </select>
          </div>

          <div class="form-group sound-tags">
            <label> Sound Tags </label>
            <input type="text" class="form-control" required name="sound_tags" data-role="tagsinput" >
          </div>

          <div class="form-group">
            <label> Sound Artwork </label>
            <input type="file" required accept="image/*" name="sound_artwork" onchange="preview_image(this, 'add_preview_artwork');"  >
            <img id="add_preview_artwork" width="100" > 
          </div>

          <div class="form-group sound-tags">
            <label> MP3 </label>
            <input type="checkbox" name="mp3" value="mp3_sound_section" onchange="show_hide_sound_section(this.value, this.checked, this.name);" >
            <label> WAV </label>
            <input type="checkbox" name="wav" value="wav_sound_section" onchange="show_hide_sound_section(this.value, this.checked, this.name);"  >
            <label> STEM (ZIP) </label>
            <input type="checkbox" name="stem" value="stem_sound_section" onchange="show_hide_sound_section(this.value, this.checked, this.name);"  >
            <p class="text-danger" id="file_type_error">Please select atleast one file type.</p>
          </div>

          <div class="sound-section" id="mp3_sound_section">
            <label>MP3</label>
            <div class="sound-file" id="mp3-sound-file-1">
              <div class="row">
                <div class="col-md-3">
                  <input type="file" name="mp3_file[]" id="mp3_file" onchange="show_add_more('mp3', 1);" accept="audio/mp3" >
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" class="form-control" name="mp3_sound_bpm[]" step="1" placeholder="BPM" id="mp3_sound_bpm_input_1" >
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" name="mp3_sound_key[]" placeholder="Key" id="mp3_sound_key_input_1" >
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" class="form-control" required name="mp3_credit_amount[]" step="0.01" id="mp3_credit_amount_input_1" placeholder="Credit" >
                  </div>
                </div>
              </div>
              <div class="icon-remove" id="icon-remove-mp3" >
                <button type="button" class="btn add-btn" onclick="add_more('mp3');" id="mp3-add-btn-1" >
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn delete-btn" onclick="delete_file('mp3', 1);" id="mp3-delete-btn-1" >
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="sound-section" id="wav_sound_section">
            <label>WAV</label>
            <div class="sound-file" id="wav-sound-file-1">
              <div class="row">
                <div class="col-md-3">
                  <input type="file" name="wav_file[]" id="wav_file" onchange="show_add_more('wav', 1);" accept="audio/wav" >
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" class="form-control" name="wav_sound_bpm[]" step="1" placeholder="BPM" >
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" name="wav_sound_key[]" placeholder="Key" >
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" class="form-control" required name="wav_credit_amount[]" step="0.01" id="wav_credit_amount_input_1" placeholder="Credit" >
                  </div>
                </div>
              </div>
              <div class="icon-remove" id="icon-remove-wav" >
                <button type="button" class="btn" onclick="add_more('wav');" id="wav-add-btn-1" >
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn delete-btn" onclick="delete_file('wav', 1);" id="wav-delete-btn-1" >
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="sound-section" id="stem_sound_section">
            <label>STEM(ZIP)</label>
            <div class="sound-file" id="stem-sound-file-1">
              <div class="row">
                <div class="col-md-3">
                  <input type="file" name="stem_file[]" id="stem_file" onchange="show_add_more('stem', 1);" accept=".zip, .rar" >
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" class="form-control" name="stem_sound_bpm[]" step="1" placeholder="BPM" >
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="text" class="form-control" name="stem_sound_key[]" placeholder="Key" >
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input type="number" class="form-control" required name="stem_credit_amount[]" step="0.01" placeholder="Credit" >
                  </div>
                </div>
              </div>
              <div class="icon-remove" id="icon-remove-stem" >
                <button type="button" class="btn" onclick="add_more('stem');" id="stem-add-btn-1" >
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn delete-btn" onclick="delete_file('stem', 1);" id="stem-delete-btn-1" >
                  <i class="fa fa-times" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </div>
          <p class="text-danger" id="minimum_file_error">Please select atleast one file.</p>

          <div id="responseMessage"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-submit" > Add </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>

  </div>
</div>

<!-- Modal -->
<div id="editBlogModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="updateCategoryForm" name="updateCategoryForm" method="POST" onsubmit="update_category(event);" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Collection</h4>
        </div>
        <div class="modal-body" id="edit-modal-body" > </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success btn-submit" > Update </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </form>

  </div>
</div>

<?php include_once('include/tinymce.php');?>

<?php include_once('include/footer.php');?>

<script src="<?=base_url(); ?>assets/site/js/bootstrap-tagsinput.js"></script>

<script>
  function preview_image(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#' + previewId).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function add_collection(e){
    e.preventDefault();
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: site_url + 'Admin_Collections/Add',
      data: new FormData($('#addCollectionForm')[0]),
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function () {
        $("#responseMessage").html("");
        $(".btn-submit").prop('disabled', true);
        $(".btn-submit").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      },
      success: function (response) {
        if (response.status == 1) {
          $('#addCollectionForm')[0].reset();
          $('#add_preview_image').attr('src', '');
        }
        $(".btn-submit").prop('disabled', false);
        $(".btn-submit").html('Add');
        location.reload();
      }
    })
  }

  function delete_collection(collection_id){
    if(confirm("Are you sure want to delete this collection?")){
      $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: site_url + 'Admin_Collections/Delete',
        data: {
          'collection_id' : collection_id
        },
        beforeSend: function () {
        },
        success: function (response) {
          location.reload();
        }
      })
    }
  }

  function get_collection(collection_id){
    $.ajax({
      type: "POST",
      dataType: 'html',
      url: site_url + 'Admin_Collections/Get',
      data: {
        'collection_id' : collection_id
      },
      beforeSend: function () {
        $("#edit-modal-body").html("");
        $('#editBlogModal').modal('show');
        $('#editBlogModal').addClass('text-center');
        $("#edit-modal-body").html('<i style="font-size: 50px;" class="fa fa-spin fa-spinner"></i>');
      },
      success: function (response) {
        $('#editBlogModal').removeClass('text-center');
        $("#edit-modal-body").html("");
        $("#edit-modal-body").html(response);
      }
    })
  }

  function update_category(e){
    e.preventDefault();
    $("#edit-description").val();
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: site_url + 'Admin_Collections/Update',
      data: new FormData($('#updateCategoryForm')[0]),
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function () {
        $("#editResponseMessage").html("");
        $(".btn-submit").prop('disabled', true);
        $(".btn-submit").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      },
      success: function (response) {
        $("#editResponseMessage").html(response.responseMessage);
        $(".btn-submit").prop('disabled', false);
        $(".btn-submit").html('Update');
        location.reload();
      }
    })
  }

  function update_feature_category(collection_id){
    let category_status = $("#is_featured_" + collection_id).is(":checked");
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: site_url + 'Admin_Collections/update_featured',
      data: {
        'collection_id' : collection_id,
        'category_status' : (category_status) ? 1 : 0,
      },
      beforeSend: function () {
        $("#featuredStatus").html("");
      },
      success: function (response) {
        $("#featuredStatus").html(response.responseMessage);
      }
    })
  }

  function get_sub_categories(sound_id, sub_categories_input){
    if(sound_id){
      $.ajax({
        type: "POST",
        dataType: 'html',
        url: site_url + 'Admin_Sound/get_sub_category/' + sound_id,
        beforeSend: function () {
          $("#" + sub_categories_input).html('<option value="0"> Loading Sub Genres... </option>');
        },
        success: function (response) {
          $("#" + sub_categories_input).html(response);
        }
      })
    }else{
      $("#" + sub_categories_input).html('<option value=""> Select Another Genres </option>');
    }
  }

  let sound_types = {};
  let total_sound_files = {};
  total_sound_files.mp3 = 0;
  total_sound_files.wav = 0;
  total_sound_files.stem = 0;
  function show_hide_sound_section(sound_section, sound_status, sound_type){
    (sound_status) ? $("#" + sound_section).show() : $("#" + sound_section).hide();
    sound_types[sound_type] = (sound_status) ? 1 : 0;
  }

  let add_file_index = 1;
  let mp3_file_index = 1;
  let wav_file_index = 1;
  let stem_file_index = 1;
  function add_more(file_type){
    let accept_file = '';
    if(file_type == 'mp3'){
      mp3_file_index++;
      add_file_index = mp3_file_index;
      accept_file = 'audio/mp3';
    }
    if(file_type == 'wav'){
      wav_file_index++;
      add_file_index = wav_file_index;
      accept_file = 'audio/wav';
    }
    if(file_type == 'stem'){
      stem_file_index++;
      add_file_index = stem_file_index;
      accept_file = '.zip, .rar';
    }
    // add_file_index++;
    let prev_file_index = add_file_index - 1;
    $('#' + file_type + '_sound_section').append('<div class="sound-file" id="' + file_type + '-sound-file-' + add_file_index + '"><div class="row"><div class="col-md-3"><input type="file" name="' + file_type + '_file[]" onchange="show_add_more(' + "'" + file_type + "-" + add_file_index + "'" + ');" accept="' + accept_file + '" ></div><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="' + file_type + '_sound_bpm[]" step="1" placeholder="BPM" ></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="' + file_type + '_sound_key[]" placeholder="Key" ></div></div><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" required name="' + file_type + '_credit_amount[]" step="0.01" placeholder="Credit" ></div></div></div><div class="icon-remove" id="icon-remove-' + file_type + '-' + add_file_index + '" ><button type="button" class="btn  add-btn" onclick="add_more(' + "'" + file_type + "'" + ');" id="' + file_type + '-add-btn-' + add_file_index + '" ><i class="fa fa-plus" aria-hidden="true"></i></button><button type="button" class="btn delete-btn" onclick="delete_file(' + "'" + file_type + "', " + add_file_index + ');" id="' + file_type + '-delete-btn-' + add_file_index + '" ><i class="fa fa-times" aria-hidden="true"></i></button></div>');

    $("#" + file_type + "-add-btn-" + prev_file_index).hide();
    $("#" + file_type + "-add-btn-" + add_file_index).show();
    $("#" + file_type + "-delete-btn-" + prev_file_index).show();
  }

  function show_add_more(btn_id, btn_index){
    let can_add_more = true;
    if(btn_id.includes("mp3")){
      total_sound_files.mp3 = total_sound_files.mp3 + 1;
      if(total_sound_files.mp3 >= 10){
        can_add_more = false;
        $("#max_file_warning_mp3").show();
      }
    }
    if(btn_id.includes("wav")){
      total_sound_files.wav = total_sound_files.wav + 1;
      if(total_sound_files.wav >= 10){
        can_add_more = false;
        $("#max_file_warning_wav").show();
      }
    }
    if(btn_id.includes("stem")){
      total_sound_files.stem = total_sound_files.stem + 1;
      if(total_sound_files.stem >= 10){
        can_add_more = false;
        $("#max_file_warning_stem").show();
      }
    }
    if(can_add_more){
      $("#icon-remove-" + btn_id).show();
      $("#" + btn_id + "-add-btn-" + btn_index).show();
    }
  }

  function delete_file(sound_div, div_index){
    $("#" + sound_div + "-sound-file-" + div_index).remove();

    if(sound_div.includes("mp3")){
      total_sound_files.mp3 = total_sound_files.mp3 - 1;
    }
    if(sound_div.includes("wav")){
      total_sound_files.wav = total_sound_files.wav - 1;
    }
    if(sound_div.includes("stem")){
      total_sound_files.stem = total_sound_files.stem - 1;
    }
  }

  function edit_add_more(file_type, edit_file_index){
    edit_file_index = parseInt(edit_file_index) + 1;
    let accept_file = '';
    if(file_type == 'mp3'){
      // mp3_file_index++;
      // add_file_index = mp3_file_index;
      accept_file = 'audio/mp3';
    }
    if(file_type == 'wav'){
      // wav_file_index++;
      // add_file_index = wav_file_index;
      accept_file = 'audio/wav';
    }
    if(file_type == 'stem'){
      // stem_file_index++;
      // add_file_index = stem_file_index;
      accept_file = '.zip, .rar';
    }
    // edit_file_index++;
    let edit_prev_file_index = edit_file_index - 1;
    $('#edit_' + file_type + '_sound_section').append('<div class="sound-file" id="' + file_type + '-edit-sound-file-' + edit_file_index + '"><div class="row"><div class="col-md-3"><input type="file" name="' + file_type + '_file[]" onchange="edit_show_add_more(' + "'" + file_type + "-" + edit_file_index + "'" + ', ' + edit_file_index + ');" accept="' + accept_file + '" ></div><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" name="' + file_type + '_sound_bpm[]" step="1" placeholder="BPM" ></div></div><div class="col-md-3"><div class="form-group"><input type="text" class="form-control" name="' + file_type + '_sound_key[]" placeholder="Key" ></div></div><div class="col-md-3"><div class="form-group"><input type="number" class="form-control" required name="' + file_type + '_credit_amount[]" step="0.01" placeholder="Credit" ></div></div></div><div class="icon-remove" id="edit-icon-remove-' + file_type + '-' + edit_file_index + '" ><button type="button" class="btn add-btn" onclick="edit_add_more(' + "'" + file_type + "'" + ',' + edit_file_index + ');" id="' + file_type + '-edit-btn-' + edit_file_index + '" ><i class="fa fa-plus" aria-hidden="true"></i></button><button type="button" class="btn delete-btn" onclick="edit_delete_file(' + "'" + file_type + "', " + edit_file_index + ');" id="' + file_type + '-edit-delete-btn-' + edit_file_index + '" ><i class="fa fa-times" aria-hidden="true"></i></button></div>');

    $("#" + file_type + "-edit-btn-" + edit_prev_file_index).hide();
    $("#" + file_type + "-edit-btn-" + edit_file_index).show();
    $("#" + file_type + "-edit-delete-btn-" + edit_prev_file_index).show();
  }

  let total_edit_sound_files = {};
  total_edit_sound_files.mp3 = 0;
  total_edit_sound_files.wav = 0;
  total_edit_sound_files.stem = 0;
  function edit_show_add_more(btn_id, btn_index){
    let can_add_more = true;
    if(btn_id.includes("mp3")){
      total_edit_sound_files.mp3 = total_edit_sound_files.mp3 + 1;
      if(total_edit_sound_files.mp3 >= 10){
        can_add_more = false;
        $("#max_file_warning_mp3").show();
      }
    }
    if(btn_id.includes("wav")){
      total_edit_sound_files.wav = total_edit_sound_files.wav + 1;
      if(total_edit_sound_files.wav >= 10){
        can_add_more = false;
        $("#max_file_warning_wav").show();
      }
    }
    if(btn_id.includes("stem")){
      total_edit_sound_files.stem = total_edit_sound_files.stem + 1;
      if(total_edit_sound_files.stem >= 10){
        can_add_more = false;
        $("#max_file_warning_stem").show();
      }
    }

    if(can_add_more){
      $("#edit-icon-remove-" + btn_id).show();
      $("#" + btn_id + "-edit-btn-" + btn_index).show();
    }
  }

  function edit_delete_file(sound_div, div_index){
    $("#" + sound_div + "-edit-sound-file-" + div_index).remove();

    if(sound_div.includes("mp3")){
      total_edit_sound_files.mp3 = total_edit_sound_files.mp3 - 1;
    }
    if(sound_div.includes("wav")){
      total_edit_sound_files.wav = total_edit_sound_files.wav - 1;
    }
    if(sound_div.includes("stem")){
      total_edit_sound_files.stem = total_edit_sound_files.stem - 1;
    }
  }

  function add_collection_new(e){
    e.preventDefault();
    if(check_form()){
      $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: site_url + 'Admin_Collections/Add_New',
        data: new FormData($('#addCollectionForm')[0]),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
          $("#responseMessage").html("");
          $(".btn-submit").prop('disabled', true);
          $(".btn-submit").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
        },
        success: function (response) {
          if (response.status == 1) {
            $('#addCollectionForm')[0].reset();
            $('#add_preview_image').attr('src', '');
          }
          $(".btn-submit").prop('disabled', false);
          $(".btn-submit").html('Add');
          location.reload();
        }
      })
    }
  }

  function check_form(){
    let valid = true;
    let mp3_invalid = false; 
    let wav_invalid = false; 
    let stem_invalid = false; 
    $("#file_type_error").hide();
    $("#minimum_file_error").hide();
    if(!Object.keys(sound_types).length){
      $("#file_type_error").show();
      valid = false;
    }else{
      if(!total_sound_files.mp3){
        mp3_invalid = true;
      }
      if(!total_sound_files.wav){
        wav_invalid = true;
      }
      if(!total_sound_files.stem){
        stem_invalid = true;
      }
      if(mp3_invalid && wav_invalid && stem_invalid){
        valid = false;
        $("#minimum_file_error").show();
      }
    }
    return valid;
  }
</script>