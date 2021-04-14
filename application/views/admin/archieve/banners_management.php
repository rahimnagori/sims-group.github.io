<?php include_once('include/header.php'); ?>

<style>
#addToolError, .editToolError, .delete-btn, .add-btn, .icon-remove, .sound-section, #file_type_error, #minimum_file_error, #max_file_warning_mp3, #max_file_warning_wav, #max_file_warning_stem{
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
</style>
<link rel="stylesheet" href="<?=$BASE_URL; ?>assets/site/css/bootstrap-tagsinput.css">
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Banners 
      <small>Management</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Banners Management</li>
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
            <span class="font-weight-bold text-uppercase">Banners Management</span>
            <span class="pull-right" ><a href="#" class="btn btn-info" data-toggle="modal" data-target="#addBannerModal" > Add Banner </a></span>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table id="boottable" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>S.NO.</th>
                    <th>Banner Heading</th>
                    <th>Banner Description</th>
                    <th>Banner Image</th>
                    <th>Banner Collection</th>
                    <th>Banner Sound</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    foreach($banners as $serialNumber => $banner){
                  ?>
                      <tr>
                        <td><?=$serialNumber + 1; ?></td>
                        <td><?=$banner['heading'];?></td>
                        <td><?=$banner['description'];?></td>
                        <td><img src="<?=site_url($banner['banner_image']);?>" width="100" > </td>
                        <td><?=$banner['collection_name'];?></td>
                        <td><?=$banner['sound_title'];?></td>
                        <td>
                          <button type="button" onclick="get_banner(<?=$banner['id'];?>);" class="btn btn-info btn-xs"> Edit </button>
                          <button type="button" onclick="delete_banner(<?=$banner['id'];?>);" class="btn btn-danger btn-xs"> Delete </button>
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

<!-- Modal 
<div id="addBulkSoundModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form id="addBulkSoundForm" name="addBulkSoundForm" method="POST" onsubmit="add_sound(event);" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Sound</h4>
        </div>
        <div class="modal-body">
          <div class="form-group" style="display:none;" >
            <label> Sound Type </label>
            <select name="sound_type" class="form-control" onchange="update_sound_type('sound_input', this.value);" >
              <option value="1">MP3</option>
              <option value="2">WAV</option>
              <option value="3">ZIP</option>
            </select>
          </div>

          <div class="form-group">
            <label> Sound Genre </label>
            <select name="sound_category" class="form-control" onchange="get_sub_categories(this.value, 'sounds_input');" required >
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
            <select name="sound_sub_category" class="form-control" id="sounds_input" required >
              <option value="0">Select a Genre First</option>
            </select>
          </div>

          <div class="form-group">
            <label> Sound Collection (Optional) </label>
            <select name="sound_banner_id" class="form-control" >
              <option value="">Select a Collection</option>
              <?php
                foreach($banners as $banner){
              ?>
                  <option value="<?=$banner['id'];?>"><?=$banner['collection_name'];?></option>
              <?php
                }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label> Sound Title </label>
            <input type="text" class="form-control" required name="sound_title" >
          </div>

          <div class="form-group">
            <label> Sound Description </label>
            <textarea class="form-control textarea" required name="sound_description"></textarea>
          </div>

          <div class="form-group">
            <label> Credit Amount </label>
            <input type="number" class="form-control" required name="credit_amount" step="0.01" >
          </div>

          <div class="form-group">
            <label> Sound BPM </label>
            <input type="number" class="form-control" required name="sound_bpm" step="1" >
          </div>

          <div class="form-group">
            <label> Sound Key </label>
            <input type="text" class="form-control" required name="sound_key" >
          </div>

          <div class="form-group sound-tags">
            <label> Sound Tags </label>
            <input type="text" class="form-control" required name="sound_tags" data-role="tagsinput" >
          </div>

          <div class="form-group">
            <label> Sound Artwork </label>
            <input type="file" required accept="image/*" name="sound_artwork" onchange="preview_image(this, 'add_preview_image');"  >
            <img id="add_preview_image" width="100" > 
          </div>

          <div class="form-group sound-tags">
            <label> MP3 </label>
            <input type="checkbox" name="" value="mp3_sound_section" onchange="show_hide_sound_section(this.value, this.checked);" >
            <label> WAV </label>
            <input type="checkbox" name="" value="wav_sound_section" onchange="show_hide_sound_section(this.value, this.checked);"  >
            <label> STEM (ZIP) </label>
            <input type="checkbox" name="" value="stem_sound_section" onchange="show_hide_sound_section(this.value, this.checked);"  >
          </div>

          <div class="sound-section" id="mp3_sound_section">
            <label>MP3</label>
            <div class="sound-file" id="mp3-sound-file-1">
              <div class="row">
                <div class="col-md-12">
                  <input type="file" required name="mp3_file[]" id="mp3_file" onchange="show_add_more('mp3', 1);" >
                </div>
              </div>
              <div class="icon-remove" id="icon-remove-mp3" >
                <button type="button" class="btn" onclick="add_more('mp3');" id="mp3-add-btn-1" >
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
                <div class="col-md-12">
                  <input type="file" required name="wav_file[]" id="wav_file" onchange="show_add_more('wav', 1);" >
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
                <div class="col-md-12">
                  <input type="file" required name="stem_file[]" id="stem_file" onchange="show_add_more('stem', 1);" >
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
-->

<!-- Modal -->
<div id="addBannerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="addBannerForm" name="addBannerForm" method="POST" onsubmit="add_new_banner(event);" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Banner</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label> Banner Heading </label>
            <input type="text" class="form-control" required name="heading" >
          </div>

          <div class="form-group">
            <label> Banner Description </label>
            <textarea class="form-control" required name="description"></textarea>
          </div>

          <div class="form-group">
            <label> Collection </label>
            <select name="collection_id" class="form-control" onchange="get_sub_sounds(this.value, 'sounds_input');" required >
              <option value="">Select a Collection</option>
              <?php
                foreach($collections as $collection){
              ?>
                  <option value="<?=$collection['id'];?>"><?=$collection['collection_name'];?></option>
              <?php
                }
              ?>
            </select>
          </div>

          <div class="form-group" id="sub_categories">
            <label> Banner Sound </label>
            <select name="sound_id" class="form-control" id="sounds_input" required >
              <option value="0">Select a Collection First</option>
            </select>
          </div>

          <div class="form-group">
            <label> Banner Image </label>
            <input type="file" required accept="image/*" name="banner_image" onchange="preview_image(this, 'add_preview_image');" >
            <img id="add_preview_image" src="" width="100" >
          </div>

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
<div id="editBannerModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <form id="updateCategoryForm" name="updateCategoryForm" method="POST" onsubmit="update_category(event);" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Banner</h4>
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

  function delete_banner(banner_id){
    if(confirm("Are you sure want to delete this collection?")){
      $.ajax({
        type: "POST",
        dataType: 'JSON',
        url: site_url + 'Admin_Banners/Delete',
        data: {
          'banner_id' : banner_id
        },
        beforeSend: function () {
        },
        success: function (response) {
          location.reload();
        }
      })
    }
  }

  function get_banner(banner_id){
    $.ajax({
      type: "POST",
      dataType: 'html',
      url: site_url + 'Admin_Banners/Get',
      data: {
        'banner_id' : banner_id
      },
      beforeSend: function () {
        $("#edit-modal-body").html("");
        $('#editBannerModal').modal('show');
        $('#editBannerModal').addClass('text-center');
        $("#edit-modal-body").html('<i style="font-size: 50px;" class="fa fa-spin fa-spinner"></i>');
      },
      success: function (response) {
        $('#editBannerModal').removeClass('text-center');
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
      url: site_url + 'Admin_Banners/Update',
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
        // $("#editResponseMessage").html(response.responseMessage);
        $(".btn-submit").prop('disabled', false);
        $(".btn-submit").html('Update');
        location.reload();
      }
    })
  }

  function get_sub_sounds(collection_id, sounds_input){
    if(collection_id){
      $.ajax({
        type: "POST",
        dataType: 'html',
        url: site_url + 'Admin_Banners/get_collection_sound/' + collection_id,
        beforeSend: function () {
          $("#" + sounds_input).html('<option value="0"> Loading Sounds... </option>');
        },
        success: function (response) {
          $("#" + sounds_input).html(response);
        }
      })
    }else{
      $("#" + sounds_input).html('<option value=""> Select Another Genres </option>');
    }
  }

  function add_new_banner(e){
    e.preventDefault();
    $.ajax({
      type: "POST",
      dataType: 'JSON',
      url: site_url + 'Admin_Banners/Add',
      data: new FormData($('#addBannerForm')[0]),
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
          $('#addBannerForm')[0].reset();
          $('#add_preview_image').attr('src', '');
        }
        $(".btn-submit").prop('disabled', false);
        $(".btn-submit").html('Add');
        location.reload();
      }
    })
  }
</script>