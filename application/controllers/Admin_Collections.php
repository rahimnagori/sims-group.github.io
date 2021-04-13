<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Collections extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Common_Model');
    if(!$this->check_login()){
      redirect('Admin');
    }
  }

  public function check_login(){
    return ($this->session->userdata('is_admin_logged_in')) ? true : false;
  }

  public function index(){
    $pageData = [];
    $admin_id = $this->session->userdata('id');
    $where['id'] = $admin_id;
    $adminData = $this->Common_Model->fetch_records('admins', $where, false, true);
    $pageData['adminData'] = $adminData;
    $pageData['collections'] = $this->Common_Model->fetch_records('collections', false, false, false, 'id');
    $pageData['categories'] = $this->Common_Model->fetch_records('categories', array('parent_category' => 0));

    $this->load->view('admin/collections_management', $pageData);
  }

  public function Add(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');
    $admin_id = $this->session->userdata('id');
    $insert = $this->input->post();
    if($_FILES['collection_icon']['error'] == 0){
      $config['upload_path'] = "assets/site/images/collections/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('collection_icon')) {
        $collectionImage = $this->upload->data("file_name");

        $insert['collection_icon'] = "assets/site/images/collections/" .$collectionImage;
        if($this->Common_Model->insert('collections', $insert)){
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success('Collection created successfully.');
        }
      }else{
        $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
      }
    }else{
      $response['responseMessage'] = $this->Common_Model->error('Error with image');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Delete(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');
    $where['id'] = $this->input->post('collection_id');
    if($this->Common_Model->delete('collections', $where)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Collection deleted successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Get(){
    $whereCollection['id'] = $this->input->post('collection_id');
    $pageData['collectionDetails'] = $this->Common_Model->fetch_records('collections', $whereCollection, false, true);

    $whereSounds['sound_collection_id'] = $whereCollection['id'];
    $pageData['soundDetails'] = $this->Common_Model->fetch_records('sounds', $whereSounds, false, true);

    $pageData['categories'] = $this->Common_Model->fetch_records('categories', array('parent_category' => 0));

    $pageData['subCategories'] = $this->Common_Model->fetch_records('categories', array('parent_category' => $pageData['soundDetails']['sound_category']));

    $whereSounds['sound_type'] = 1;
    $pageData['mp3CollectionSounds'] = $this->Common_Model->fetch_records('sounds', $whereSounds);

    $whereSounds['sound_type'] = 2;
    $pageData['wavCollectionSounds'] = $this->Common_Model->fetch_records('sounds', $whereSounds);

    $whereSounds['sound_type'] = 3;
    $pageData['stemCollectionSounds'] = $this->Common_Model->fetch_records('sounds', $whereSounds);

    $pageData['mp3'] = (!empty($pageData['mp3CollectionSounds'])) ? 1 : 0;
    $pageData['wav'] = (!empty($pageData['wavCollectionSounds'])) ? 1 : 0;
    $pageData['stem'] = (!empty($pageData['stemCollectionSounds'])) ? 1 : 0;

    $this->load->view('admin/edit_collection', $pageData);
    // echo "<pre>";
    // print_r($pageData);
    // die;
  }

  public function Update(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update['collection_name'] = $this->input->post('collection_name');
    $update['collection_description'] = $this->input->post('collection_description');

    $where['id'] = $this->input->post('collection_id');

    if($_FILES['icon_update']['error'] == 0){
      $config['upload_path'] = "assets/site/images/collections/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('icon_update')) {
        $collectionImage = $this->upload->data("file_name");

        $update['collection_icon'] = "assets/site/images/collections/" .$collectionImage;
        $icon_old = $this->input->post('icon_old');
        if(file_exists($icon_old)) unlink($icon_old);
      }
    }
    if($this->Common_Model->update('collections', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Collection updated successfully.');
      $updateSound = $this->input->post();
      unset($updateSound['collection_name']);
      unset($updateSound['collection_id']);
      unset($updateSound['collection_description']);
      unset($updateSound['icon_old']);

      $soundArray = [];
      if(isset($updateSound['mp3'])){
        unset($updateSound['mp3']);
        $soundArray['mp3']['sound_id'] = $updateSound['update_mp3_sound_id'];
        unset($updateSound['update_mp3_sound_id']);

        $soundArray['mp3']['sound_bpm'] = $updateSound['mp3_sound_bpm'];
        unset($updateSound['mp3_sound_bpm']);

        $soundArray['mp3']['sound_key'] = $updateSound['mp3_sound_key'];
        unset($updateSound['mp3_sound_key']);

        $soundArray['mp3']['credit_amount'] = $updateSound['mp3_credit_amount'];
        unset($updateSound['mp3_credit_amount']);
      }
      if(isset($updateSound['wav'])){
        unset($updateSound['wav']);
        $soundArray['wav']['sound_bpm'] = $updateSound['wav_sound_bpm'];
        unset($updateSound['wav_sound_bpm']);

        $soundArray['wav']['sound_id'] = $updateSound['update_wav_sound_id'];
        unset($updateSound['update_wav_sound_id']);

        $soundArray['wav']['sound_key'] = $updateSound['wav_sound_key'];
        unset($updateSound['wav_sound_key']);

        $soundArray['wav']['credit_amount'] = $updateSound['wav_credit_amount'];
        unset($updateSound['wav_credit_amount']);
      }
      if(isset($updateSound['stem'])){
        unset($updateSound['stem']);

        $soundArray['stem']['sound_id'] = $updateSound['update_stem_sound_id'];
        unset($updateSound['update_stem_sound_id']);

        $soundArray['stem']['sound_bpm'] = $updateSound['stem_sound_bpm'];
        unset($updateSound['stem_sound_bpm']);

        $soundArray['stem']['sound_key'] = $updateSound['stem_sound_key'];
        unset($updateSound['stem_sound_key']);

        $soundArray['stem']['credit_amount'] = $updateSound['stem_credit_amount'];
        unset($updateSound['stem_credit_amount']);
      }
      $old_file['mp3'] = $updateSound['mp3_old_file'];
      unset($updateSound['mp3_old_file']);

      $old_file['wav'] = $updateSound['wav_old_file'];
      unset($updateSound['wav_old_file']);

      $old_file['stem'] = $updateSound['stem_old_file'];
      unset($updateSound['stem_old_file']);

      foreach($soundArray as $soundType => $sound){
        for($i = 0; $i < count($sound['sound_id']); $i++){
          $fileName = $soundType .'_file';
          $updateCollectionSound = $updateSound;
          if($_FILES[$fileName]["error"][$i] == 0){
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;
            if(move_uploaded_file($tmp_name, $path)){
              $updateCollectionSound['sound_file'] = $path;
              if(file_exists($old_file[$soundType][$i])) unlink($old_file[$soundType][$i]);
            }
          }
          /* Sound BPM */
          $updateCollectionSound['sound_bpm'] = $sound['sound_bpm'][$i];
          /* Sound Key */
          $updateCollectionSound['sound_key'] = $sound['sound_key'][$i];
          /* Sound Credit */
          $updateCollectionSound['credit_amount'] = $sound['credit_amount'][$i];

          // unset($updateSound[$soundType .'_old_file']);
          $this->Common_Model->update('sounds', array('id' => $sound['sound_id'][$i]), $updateCollectionSound);
          // $response['debug'][] = $this->db->last_query();
        }
        if(count($sound['sound_id']) < count($sound['sound_bpm'])){
          for($i = count($sound['sound_id']); $i < count($sound['sound_bpm']); $i++){
            $fileName = $soundType .'_file';
            $insertCollectionSound = $updateSound;
            if($soundType == 'mp3'){
              $insertCollectionSound['sound_type'] = 1;
            }
            if($soundType == 'wav'){
              $insertCollectionSound['sound_type'] = 2;
            }
            if($soundType == 'stem'){
              $insertCollectionSound['sound_type'] = 3;
            }
            $insertCollectionSound['sound_collection_id'] = $where['id'];
            if($_FILES[$fileName]["error"][$i] == 0){
              $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
              $extension = end($tempName);
              $file_name = rand().time().'.'.$extension;

              $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
              $path = 'assets/site/sounds/' .$file_name;
              if(move_uploaded_file($tmp_name, $path)){
                $insertCollectionSound['sound_file'] = $path;
              }
            }
            /* Sound BPM */
            $insertCollectionSound['sound_bpm'] = $sound['sound_bpm'][$i];
            /* Sound Key */
            $insertCollectionSound['sound_key'] = $sound['sound_key'][$i];
            /* Sound Credit */
            $insertCollectionSound['credit_amount'] = $sound['credit_amount'][$i];
            $insertCollectionSound['sound_created'] = date("Y-m-d H:i:s");

            // unset($updateSound[$soundType .'_old_file']);
            $this->Common_Model->insert('sounds', $insertCollectionSound);
            // $response['debug'][] = $this->db->last_query();
          }
        }
      }
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function update_featured(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');
    $where['id'] = $this->input->post('collection_id');
    $update['is_featured'] = $this->input->post('collection_status');
    if($this->Common_Model->update('collections', $where, $update)){
      $response['status'] = 1;
      $message = ($update['is_featured']) ? 'added to' : 'removed from';
      $response['responseMessage'] = $this->Common_Model->success('Collection ' .$message .' featured successfully.');
    }
    echo json_encode($response);
  }

  public function Add_New(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');
    $admin_id = $this->session->userdata('id');
    $insert['collection_name'] = $this->input->post('collection_name');
    $insert['collection_description'] = $this->input->post('collection_description');
    if($_FILES['collection_icon']['error'] == 0){
      $config['upload_path'] = "assets/site/images/collections/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('collection_icon')) {
        $collectionImage = $this->upload->data("file_name");

        $insert['collection_icon'] = "assets/site/images/collections/" .$collectionImage;
        $insert['sub_category_id'] = $this->input->post('sound_sub_category');
        $collectionId = $this->Common_Model->insert('collections', $insert);
        if($collectionId){
          /* Add and Upload Sound */
          $insertSound = $this->input->post();
          $insertSound['sound_collection_id'] = $collectionId;
          $insertSound['sound_title'] = $insertSound['collection_name'];
          $insertSound['sound_description'] = $insertSound['collection_description'];
          $insertSound['sound_created'] = $insertSound['sound_updated'] = date("Y-m-d H:i:s");

          unset($insertSound['collection_name']);
          unset($insertSound['collection_description']);
          if(isset($insertSound['mp3'])) unset($insertSound['mp3']);
          if(isset($insertSound['wav'])) unset($insertSound['wav']);
          if(isset($insertSound['stem'])) unset($insertSound['stem']);
          if(isset($insertSound['mp3_sound_bpm'])){
            $mp3_sound_bpm = $insertSound['mp3_sound_bpm'];
            $mp3_sound_key = $insertSound['mp3_sound_key'];
            $mp3_credit_amount = $insertSound['mp3_credit_amount'];
            unset($insertSound['mp3_sound_bpm']);
            unset($insertSound['mp3_sound_key']);
            unset($insertSound['mp3_credit_amount']);
          }
          if(isset($insertSound['wav_sound_bpm'])){
            $wav_sound_bpm = $insertSound['wav_sound_bpm'];
            $wav_sound_key = $insertSound['wav_sound_key'];
            $wav_credit_amount = $insertSound['wav_credit_amount'];
            unset($insertSound['wav_sound_bpm']);
            unset($insertSound['wav_sound_key']);
            unset($insertSound['wav_credit_amount']);
          }
          if(isset($insertSound['stem_sound_bpm'])){
            $stem_sound_bpm = $insertSound['stem_sound_bpm'];
            $stem_sound_key = $insertSound['stem_sound_key'];
            $stem_credit_amount = $insertSound['stem_credit_amount'];
            unset($insertSound['stem_sound_bpm']);
            unset($insertSound['stem_sound_key']);
            unset($insertSound['stem_credit_amount']);
          }
          $response['responseInsert'] = [];

          $tempName = explode('.', $_FILES['sound_artwork']['name']);
          $extension = end($tempName);
          $file_name = rand().time().'.'.$extension;
          
          $tmp_name = $_FILES["sound_artwork"]["tmp_name"];
          $path = 'assets/site/sounds/artworks/' .$file_name;
          
          if(move_uploaded_file($tmp_name, $path)){
            $insertSound['sound_artwork'] = $path;
          }
          $mp3_file = count($_FILES['mp3_file']['name']);
          $fileName = 'mp3_file';
          for( $i = 0 ; $i < $mp3_file; $i++ ) {
            $insertSound['sound_type'] = 1;
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;
            // $insertSound['sound_file'] = $path;

            if(move_uploaded_file($tmp_name, $path)){
              $insertSound['sound_bpm'] = $mp3_sound_bpm[$i];
              $insertSound['sound_key'] = $mp3_sound_key[$i];
              $insertSound['credit_amount'] = $mp3_credit_amount[$i];
              $insertSound['sound_file'] = $path;
              $this->Common_Model->insert('sounds', $insertSound);
            }
            $response['responseInsert'][] = $insertSound;
          }
          $wav_file = count($_FILES['wav_file']['name']);
          $fileName = 'wav_file';
          for( $i = 0 ; $i < $wav_file; $i++ ) {
            $insertSound['sound_type'] = 2;
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;

            if(move_uploaded_file($tmp_name, $path)){
              $insertSound['sound_bpm'] = $wav_sound_bpm[$i];
              $insertSound['sound_key'] = $wav_sound_key[$i];
              $insertSound['credit_amount'] = $wav_credit_amount[$i];
              $insertSound['sound_file'] = $path;
              $this->Common_Model->insert('sounds', $insertSound);
            }
            $response['responseInsert'][] = $insertSound;
          }
          $stem_file = count($_FILES['stem_file']['name']);
          $fileName = 'stem_file';
          for( $i = 0 ; $i < $stem_file; $i++ ) {
            $insertSound['sound_type'] = 3;
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;

            if(move_uploaded_file($tmp_name, $path)){
              $insertSound['sound_bpm'] = $stem_sound_bpm[$i];
              $insertSound['sound_key'] = $stem_sound_key[$i];
              $insertSound['credit_amount'] = $stem_credit_amount[$i];
              $insertSound['sound_file'] = $path;
              $this->Common_Model->insert('sounds', $insertSound);
            }
            // $response['responseInsert'][] = $insertSound;
          }
          /* Add and Upload Sound */
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success('Collection created successfully.');
        }
      }else{
        $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
      }
    }else{
      $response['responseMessage'] = $this->Common_Model->error('Error with image');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

}
