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

    $pageData['services'] = $this->Common_Model->fetch_records('services');
    $this->load->view('admin/services_management', $pageData);
  }

  public function Add(){
    $response['status'] = 0;
    $insert = $this->input->post();
    if($this->Common_Model->insert('services', $insert)){
      $response['status'] = 1;
      $response['responseMessage'] = 'Service Added Successfully.';
    }
    echo json_encode($response);
  }

  public function update(){
    $update = $_REQUEST;
    if(trim($update['id']) != ''){
      $where['id'] = $update['id'];
      unset($update['id']);
      $this->Common_Model->update('business_details', $where, $update);
    }else{
      unset($update['id']);
      $this->Common_Model->insert('business_details', $update);
    }
    redirect('Admin/Business');
  }
}
