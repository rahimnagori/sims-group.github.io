<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

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

    $this->load->view('admin/test_view', $pageData);
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

    $this->load->view('admin/edit_collection', $pageData);
  }

  public function Update(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update = $this->input->post();
    $where['id'] = $update['collection_id'];
    unset($update['collection_id']);
    // $update['updated'] = date("Y-m-d H:i:s");
    if($_FILES['icon_update']['error'] == 0){
      $config['upload_path'] = "assets/site/images/collections/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('icon_update')) {
        $collectionImage = $this->upload->data("file_name");

        $update['collection_icon'] = "assets/site/images/collections/" .$collectionImage;
        if(file_exists($update['icon_old'])) unlink($update['icon_old']);
      }
    }
    unset($update['icon_old']);
    if($this->Common_Model->update('collections', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Collection updated successfully.');
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
        $collectionId = $this->Common_Model->insert('collections', $insert);
        if($collectionId){
          /* Add and Upload Sound */
          $insertSound = $this->input->post();
          $insertSound['sound_title'] = $insertSound['collection_name'];
          $insertSound['sound_description'] = $insertSound['collection_description'];

          unset($insertSound['collection_name']);
          unset($insertSound['collection_description']);
          unset($insertSound['mp3']);
          unset($insertSound['wav']);
          unset($insertSound['stem']);

          $mp3_file = count($_FILES['mp3_file']['name']);
          $fileName = 'mp3_file';
          for( $i = 0 ; $i < $mp3_file; $i++ ) {
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;

            if(move_uploaded_file($tmp_name, $path)){
              $insert['sound_file'] = $path;
              $this->Common_Model->insert('sounds', $insertSound);
            }
          }
          $wav_file = count($_FILES['wav_file']['name']);
          $fileName = 'wav_file';
          for( $i = 0 ; $i < $wav_file; $i++ ) {
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;

            if(move_uploaded_file($tmp_name, $path)){
              $insert['sound_file'] = $path;
              $this->Common_Model->insert('sounds', $insertSound);
            }
          }
          $stem_file = count($_FILES['stem_file']['name']);
          $fileName = 'stem_file';
          for( $i = 0 ; $i < $stem_file; $i++ ) {
            $tempName = explode('.', $_FILES[$fileName]['name'][$i]);
            $extension = end($tempName);
            $file_name = rand().time().'.'.$extension;

            $tmp_name = $_FILES[$fileName]["tmp_name"][$i];
            $path = 'assets/site/sounds/' .$file_name;

            if(move_uploaded_file($tmp_name, $path)){
              $insert['sound_file'] = $path;
              $this->Common_Model->insert('sounds', $insertSound);
            }
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
