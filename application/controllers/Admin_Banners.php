<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Banners extends CI_Controller {

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

    $joins[0][] = 'collections';
    $joins[0][] = 'home_banners.collection_id = collections.id';
    $joins[0][] = 'left';
    $joins[1][] = 'sounds';
    $joins[1][] = 'home_banners.sound_id = sounds.id';
    $joins[1][] = 'left';
    $select = 'home_banners.*, collections.collection_name, sounds.sound_title';
    $pageData['banners'] = $this->Common_Model->join_records('home_banners', $joins, false, $select, 'home_banners.id');

    $pageData['collections'] = $this->Common_Model->fetch_records('collections', false, false, false);
    $pageData['sounds'] = $this->Common_Model->fetch_records('sounds', false, false, false);

    $this->load->view('admin/banners_management', $pageData);
  }

  public function get_collection_sound($collectionId){
    $where['sound_collection_id'] = $collectionId;
    $where['sound_type !='] = 3;
    $pageData['sounds'] = $this->Common_Model->fetch_records('sounds', $where);
    $this->load->view('admin/collection_sounds', $pageData);
  }

  public function Add(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');
    $admin_id = $this->session->userdata('id');
    $insert = $this->input->post();
    if($_FILES['banner_image']['error'] == 0){
      $config['upload_path'] = "assets/site/images/banners/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('banner_image')) {
        $collectionImage = $this->upload->data("file_name");

        $insert['banner_image'] = "assets/site/images/banners/" .$collectionImage;
        if($this->Common_Model->insert('home_banners', $insert)){
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success('Banner added successfully.');
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
    $where['id'] = $this->input->post('banner_id');
    $bannerDetails = $this->Common_Model->fetch_records('home_banners', $where, false, true);
    if(file_exists($bannerDetails['banner_image'])) unlink($bannerDetails['banner_image']);
    if($this->Common_Model->delete('home_banners', $where)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Banner deleted successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Get(){
    $whereCollection['id'] = $this->input->post('banner_id');
    $pageData['bannerDetails'] = $this->Common_Model->fetch_records('home_banners', $whereCollection, false, true);
    $pageData['collections'] = $this->Common_Model->fetch_records('collections');
    $pageData['collectionSounds'] = $this->Common_Model->fetch_records('sounds', array('id' => $pageData['bannerDetails']['sound_id']));

    $this->load->view('admin/edit_banner', $pageData);
  }

  public function Update(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update = $this->input->post();
    $where['id'] = $update['banner_id'];
    unset($update['banner_id']);
    // $update['updated'] = date("Y-m-d H:i:s");
    if($_FILES['banner_image']['error'] == 0){
      $config['upload_path'] = "assets/site/images/banners/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('banner_image')) {
        $collectionImage = $this->upload->data("file_name");

        $update['banner_image'] = "assets/site/images/banners/" .$collectionImage;
        if(file_exists($update['banner_image_old'])) unlink($update['banner_image_old']);
      }
    }
    unset($update['banner_image_old']);
    if($this->Common_Model->update('home_banners', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Banner updated successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }
}
