<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   * 		http://example.com/index.php/Home
   *	- or -
   * 		http://example.com/index.php/Home/index
   *	- or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/Home/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */
  public function __construct(){
    parent::__construct();
    $this->load->model('Common_Model');
    $this->load->library('session');
    if(!$this->session->userdata('user_id')){
      redirect('');
    }
  }

  private function get_userdata(){
    $userdata = [];
    $user_id = $this->session->userdata('user_id');
    if($user_id){
      $userdata = $this->Common_Model->fetch_records('users', array('id' => $user_id), false, true);
    }
    $categories = $this->Common_Model->fetch_records('categories', array('parent_category' => 0));

    $collections = $this->Common_Model->fetch_records('collections');
    return array('userdata' => $userdata, 'categories' => $categories, 'collections' => $collections);
  }

  public function index(){
    $pageData = $this->get_userdata();
    if(empty($pageData['userdata'])) redirect('');
    if($pageData['userdata']['is_email_verified'] != 1) redirect('Email-Verify');

    $joins[0][] = 'sounds';
    $joins[0][] = 'sound_likes.sound_id = sounds.id';
    $joins[0][] = 'left';
    $select = 'sound_likes.*, sounds.sound_file, sounds.sound_type, sounds.sound_artwork, sounds.sound_title, sounds.sound_description, sounds.sound_category, sounds.sound_collection_id';
    $where['sound_likes.user_id'] = $pageData['userdata']['id'];
    $pageData['likedSounds'] = $this->Common_Model->join_records('sound_likes', $joins, $where, $select);

    $joins = [];
    $joins[0][] = 'sounds';
    $joins[0][] = 'user_downloads.sound_id = sounds.id';
    $joins[0][] = 'left';
    $select = 'user_downloads.*, sounds.sound_file, sounds.sound_type, sounds.sound_artwork, sounds.sound_title, sounds.sound_description, sounds.sound_category';
    $where = [];
    $where['user_downloads.user_id'] = $pageData['userdata']['id'];
    $pageData['downloadedSounds'] = $this->Common_Model->join_records('user_downloads', $joins, $where, $select);
    // echo $this->db->last_query();

    $categories = $this->Common_Model->fetch_records('categories');
    $pageData['categories'] = [];
    foreach($categories as $category){
      $pageData['categories'][$category['id']] = $category;
    }

    // echo "<pre>";
    // print_r($pageData['downloadedSounds']);
    // die;
    $this->load->view('site/profile_view', $pageData);
  }

  public function verify(){
    $pageData = $this->get_userdata();
    $this->load->view('site/verify', $pageData);
  }

  public function edit(){
    $pageData = $this->get_userdata();
    $this->load->view('site/edit_profile_page', $pageData);
  }

  public function update(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $update = $this->input->post();
    $where['id'] = $update['user_id'];
    unset($update['user_id']);
    $update['updated'] = date("Y-m-d H:i:s");
    if($_FILES['profile']['error'] == 0){
      $config['upload_path'] = "assets/site/images/profiles/";
      $config['allowed_types'] = 'jpeg|gif|jpg|png';
      $config['encrypt_name'] = true;
      $this->load->library("upload", $config);
      if ($this->upload->do_upload('profile')) {
        $profile = $this->upload->data("file_name");

        $update['profile'] = "assets/site/images/profiles/" .$profile;
        if(file_exists($update['profile_old'])) unlink($update['profile_old']);
      }
    }
    unset($update['profile_old']);
    if($this->Common_Model->update('users', $where, $update)){
      $response['status'] = 1;
      $response['responseMessage'] = $this->Common_Model->success('Profile updated successfully.');
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);
    echo json_encode($response);
  }

  public function update_password(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');
    $where['id'] = $this->input->post('user_id');
    $loggedInUserId = $this->session->userdata('user_id');
    if($loggedInUserId == $where['id']){
      $update['password'] = $this->input->post('password');
      $confirmPassword = $this->input->post('confirm_password');
      $where['password'] = $this->input->post('old_password');
      if($confirmPassword == $update['password']){
        $userdata = $this->Common_Model->fetch_records('users', $where, false, true);
        if($userdata){
          unset($where['password']);
          if($this->Common_Model->update('users', $where, $update)){
            $response['responseMessage'] = $this->Common_Model->success('Password changed successfully.');
          }
        }else{
          $response['responseMessage'] = $this->Common_Model->error('Wrong old password.');
        }
      }else{
        $response['responseMessage'] = $this->Common_Model->error('Password and confirm password does not match.');
      }
    }else{
      $response['responseMessage'] = $this->Common_Model->error('Sorry you are not authorized.');
    }
    echo json_encode($response);
  }

}
