<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Business extends CI_Controller {

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

    $business_details = $this->Common_Model->fetch_records('business_details');

    $pageData['businessDetails'] = (!empty($business_details)) ? $business_details[0] : $business_details;
    $this->load->view('admin/business_details', $pageData);
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
