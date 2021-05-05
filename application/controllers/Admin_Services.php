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

    $pageData['services'] = $this->Common_Model->fetch_records('services', array('is_deleted' => 0), false, false, 'id');

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

  public function image($id){
    $pageData = [];
    $admin_id = $this->session->userdata('id');
    $where['id'] = $admin_id;

    $adminData = $this->Common_Model->fetch_records('admins', $where, false, true);
    $pageData['adminData'] = $adminData;

    $pageData['serviceDetails'] = $this->Common_Model->fetch_records('services', array('id' => $id), false, true);

    $pageData['serviceImages'] = $this->Common_Model->fetch_records('service_images', array('service_id' => $id, 'is_deleted' => 0));

    $this->load->view('admin/service_images_management', $pageData);
  }

  public function Add_Image(){
    $response['status'] = 0;
    $insert = $this->input->post();
    $insert['is_deleted'] = 0;
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
    $insert['created'] = date("Y-m-d H:i:s");
    if($this->Common_Model->insert('service_images', $insert)){
      $response['status'] = 1;
      $response['responseMessage'] = 'Service Image Added Successfully.';
    }
    echo json_encode($response);
  }

  public function Get_Image(){
    $whereService['id'] = $this->input->post('service_image_id');
    $pageData['serviceImageDetails'] = $this->Common_Model->fetch_records('service_images', $whereService, false, true);

    $this->load->view('admin/edit_service_image', $pageData);
  }

  public function Update_Image(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update = $this->input->post();
    $where['id'] = $update['service_image_id'];
    unset($update['service_image_id']);
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
    if($this->Common_Model->update('service_images', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Service Image updated successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Delete_Image(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');
    $where['id'] = $this->input->post('service_image_id');
    $update['is_deleted'] = 1;
    if($this->Common_Model->update('service_images', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Service deleted successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Brochure($id){
    $pageData = [];
    $admin_id = $this->session->userdata('id');
    $where['id'] = $admin_id;

    $adminData = $this->Common_Model->fetch_records('admins', $where, false, true);
    $pageData['adminData'] = $adminData;

    $pageData['serviceDetails'] = $this->Common_Model->fetch_records('services', array('id' => $id), false, true);

    $pageData['serviceBrochures'] = $this->Common_Model->fetch_records('service_brochures', array('service_id' => $id, 'is_deleted' => 0));

    $this->load->view('admin/brochure_management', $pageData);
  }

  public function add_brochure(){
    $response['status'] = 0;
    $insert = $this->input->post();
    $insert['is_deleted'] = 0;
    if($_FILES['brochure']['error'] == 0){
      $config['upload_path'] = "assets/site/brochure/";
      $config['allowed_types'] = 'pdf';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('brochure')) {
        $brochure = $this->upload->data("file_name");

        $insert['brochure'] = "assets/site/brochure/" .$brochure;
      }else{
        $response['responseMessage'] = $this->Common_Model->error($this->upload->display_errors());
      }
    }
    $insert['created'] = date("Y-m-d H:i:s");
    if($this->Common_Model->insert('service_brochures', $insert)){
      $response['status'] = 1;
      $response['responseMessage'] = 'Service Brochure Added Successfully.';
    }
    echo json_encode($response);
  }

  public function Get_Brochure(){
    $whereService['id'] = $this->input->post('service_id');
    $pageData['brochureDetails'] = $this->Common_Model->fetch_records('service_brochures', $whereService, false, true);

    $this->load->view('admin/edit_brochure', $pageData);
  }

  public function Update_Brochure(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update = $this->input->post();
    $where['id'] = $update['brochure_id'];
    unset($update['brochure_id']);
    if($_FILES['brochure_update']['error'] == 0){
      $config['upload_path'] = "assets/site/brochure/";
      $config['allowed_types'] = 'pdf';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('brochure_update')) {
        $serviceImage = $this->upload->data("file_name");

        $update['brochure'] = "assets/site/brochure/" .$serviceImage;
        if(file_exists($update['brochure_old'])) unlink($update['brochure_old']);
      }
    }
    unset($update['brochure_old']);
    if($this->Common_Model->update('service_brochures', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Service brochure updated successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function Delete_Brochure(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');
    $where['id'] = $this->input->post('brochure_id');
    $update['is_deleted'] = 1;
    if($this->Common_Model->update('service_brochures', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Brochure deleted successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

}
