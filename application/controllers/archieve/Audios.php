<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audios extends CI_Controller {

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

  public function like_dislike(){
    if(!$this->session->userdata('user_id')){
      redirect('');
    }
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');
    $where['sound_id'] = $this->input->post('sound_id');
    $where['user_id'] = $this->session->userdata('user_id');
    $checkLikeExist = $this->Common_Model->fetch_records('sound_likes', $where, false, true);
    if($checkLikeExist){
      $this->Common_Model->delete('sound_likes', array('id' => $checkLikeExist['id']));
      $response['responseMessage'] = $this->Common_Model->success('Sound disliked successfully.');
      $response['status'] = 1;
      $response['icon'] = '<i class="fa fa-heart-o"></i>';
    }else{
      $insert = $where;
      $insert['created'] = date("Y-m-d H:i:s");
      if($this->Common_Model->insert('sound_likes', $insert)){
        $response['responseMessage'] = $this->Common_Model->success('Sound liked successfully.');
        $response['status'] = 1;
        $response['icon'] = '<i class="fa fa-heart"></i>';
      }
    }
    echo json_encode($response);
  }

  public function Get(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Song not found.');
    $where['id'] = $this->input->post('sound_id');
    $soundDetails = $this->Common_Model->fetch_records('sounds', $where, false, true);
    if(file_exists($soundDetails['sound_file'])){
      $response['status'] = 1;
      $soundFile = file_get_contents($soundDetails['sound_file']);
      $response['file'] = base64_encode($soundFile);
      $response['fileType'] = $soundDetails['sound_type'];
      if($response['fileType'] == 3){
        $hash = uniqid();
        $file[$hash] = $soundDetails['sound_file'];
        $this->session->set_userdata('files', $file);
        $response['fileId'] = $hash;
        $extension = explode('.', $soundDetails['sound_file']);
        $response['newFilename'] = 'auxhole_' .time() .'.' .end($extension);
      }
    }
    echo json_encode($response);
  }

}
