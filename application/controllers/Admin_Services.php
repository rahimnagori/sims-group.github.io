<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Services extends CI_Controller {

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

    $pageData['services'] = $this->Common_Model->fetch_records('services', array('is_deleted' => 0));

    $this->load->view('admin/services_management', $pageData);
  }

  public function Add(){
    $response['status'] = 0;
    $insert = $this->input->post();
    if($_FILES['service_image']['error'] == 0){
      $config['upload_path'] = "assets/site/img/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('service_image')) {
        $serviceImage = $this->upload->data("file_name");

        $insert['service_image'] = "assets/site/img/" .$serviceImage;
      }else{
        $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
      }
    }
    if($this->Common_Model->insert('services', $insert)){
      $response['status'] = 1;
      $response['responseMessage'] = 'Service Added Successfully.';
    }
    echo json_encode($response);
  }

  public function Get(){
    $whereService['id'] = $this->input->post('service_id');
    $pageData['serviceDetails'] = $this->Common_Model->fetch_records('services', $whereService, false, true);

    $this->load->view('admin/edit_service', $pageData);
  }

  public function Update(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update = $this->input->post();
    $where['id'] = $update['service_id'];
    unset($update['service_id']);
    if($_FILES['service_image_update']['error'] == 0){
      $config['upload_path'] = "assets/site/img/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('service_image_update')) {
        $serviceImage = $this->upload->data("file_name");

        $update['service_image'] = "assets/site/img/" .$serviceImage;
        if(file_exists($update['thumbnail_old'])) unlink($update['thumbnail_old']);
      }
    }
    unset($update['thumbnail_old']);
    if($this->Common_Model->update('services', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Services updated successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Delete(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');
    $where['id'] = $this->input->post('service_id');
    $update['is_deleted'] = 1;
    if($this->Common_Model->update('services', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Service deleted successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }
}
