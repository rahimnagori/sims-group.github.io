<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

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

    $whereSound['id'] = $this->input->post('sound_id');
    $pageData['downloadSounds'] = $this->Common_Model->fetch_records('sounds', $whereSound);

    // $file = $pageData['downloadSounds'][0]['sound_file'];
    // $response['file'] = site_url($file);
    // echo json_encode($response);

    $this->load->view('site/download_sound', $pageData);
  }

  public function Bulk(){
    $pageData = $this->get_userdata();
    if(empty($pageData['userdata'])) redirect('');
    if($pageData['userdata']['is_email_verified'] != 1) redirect('Email-Verify');

    $whereSound['sound_sub_category'] = $this->input->post('category_id');
    $pageData['downloadSounds'] = $this->Common_Model->fetch_records('sounds', $whereSound);

    $this->load->view('site/download_sound', $pageData);

  }

  public function Pay(){
    $user_id = $this->session->userdata('user_id');
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later');

    $insert = $this->input->post();
    $totalCredits = $this->Common_Model->check_credit($user_id);

    if($insert['sound']){
      $whereSound['id'] = $insert['sound'];
      $soundDetails = $this->Common_Model->fetch_records('sounds', $whereSound, false, true);

      if($totalCredits >= $soundDetails['credit_amount']){
        $whereUser['id'] = $user_id;
        $updateUser['total_credits'] = $totalCredits - $soundDetails['credit_amount'];
        if($this->Common_Model->update('users', $whereUser, $updateUser)){
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success('Sound downloaded successfully. Your remaining credit is ' .$updateUser['total_credits']);
        }
      }else{
        $response['status'] = 2;
        $response['responseMessage'] = $this->Common_Model->error('Insufficient balance.');
      }
    }
    if($insert['category']){
      $whereSound['sound_sub_category'] = $insert['category'];
      $select = 'SUM(`credit_amount`) AS `total_credit_amount`';
      $soundDetails = $this->Common_Model->fetch_records('sounds', $whereSound, $select, true);
      if($totalCredits >= $soundDetails['total_credit_amount']){
        $whereUser['id'] = $user_id;
        $updateUser['total_credits'] = $totalCredits - $soundDetails['total_credit_amount'];
        if($this->Common_Model->update('users', $whereUser, $updateUser)){
          $response['status'] = 1;
          $response['responseMessage'] = $this->Common_Model->success('Sound downloaded successfully. Your remaining credit is ' .$updateUser['total_credits']);
        }
      }else{
        $response['status'] = 2;
        $response['responseMessage'] = $this->Common_Model->error('Insufficient balance.');
      }
    }

    echo json_encode($response);
  }

  public function Add(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');

    $user_id = $this->session->userdata('user_id');
    $insert['sound_id'] = $this->input->post('sound_id');
    $soundDetails = $this->Common_Model->fetch_records('sounds', array('id' => $insert['sound_id']), false, true);

    if($soundDetails){
      if(file_exists($soundDetails['sound_file'])){
        $userdata = $this->Common_Model->fetch_records('users', array('id' => $user_id), false, true);
        if($userdata['total_credits'] >= $soundDetails['credit_amount']){
          $insert['user_id'] = $user_id;

          $where = $insert;
          $checkExist = $this->Common_Model->fetch_records('user_downloads', $where, false, true);

          if($soundDetails['sound_type'] == 3){
            $hash = uniqid();
            $file[$hash] = $soundDetails['sound_file'];
            $this->session->set_userdata('files', $file);
            $response['file'] = $hash;
            $extension = explode('.', $soundDetails['sound_file']);
            $response['filename'] = 'auxhole_' .time() .'.' .end($extension);
          }
          if($checkExist){
            $response['status'] = 2;
            $response['responseMessage'] = $this->Common_Model->error('You have already downloaded this song.');
          }else{
            $insert['collection_id'] = $soundDetails['sound_collection_id'];
            $insert['created'] = date("Y-m-d H:i:s");
            if($this->Common_Model->insert('user_downloads', $insert)){
              $this->update_wallet($user_id, $soundDetails['credit_amount'], 0);
              $response['status'] = 1;
              $response['responseMessage'] = $this->Common_Model->success('Song downloaded successfully. Please check your <a href="' .site_url('Profile') .'">downloads</a>.');
            }
          }
        }else{
          $response['status'] = 3;
          $response['responseMessage'] = $this->Common_Model->error('Sorry you do not have much credit for this.');
        }
      }else{
        $response['responseMessage'] = $this->Common_Model->error('Song does not exist.');
      }
    }else{
      $response['responseMessage'] = $this->Common_Model->error('Song does not exist.');
    }
    echo json_encode($response);
  }

  private function update_wallet($user_id, $amount, $transactionType){
    /* 
      $transactionType
      0 = debit,
      1 = credit
    */
    $where['id'] = $user_id;
    $userdata = $this->Common_Model->fetch_records('users', $where, false, true);
    if($transactionType == 1){
      $update['total_credits'] = $userdata['total_credits'] + $amount;
    }else{
      $update['total_credits'] = $userdata['total_credits'] - $amount;
    }
    $this->Common_Model->update('users', $where, $update);
  }

  public function Add_Bulk(){
    $response['status'] = 0;
    $response['responseMessage'] = $this->Common_Model->error('Server error, please try again later.');

    $user_id = $this->session->userdata('user_id');
    $insert['collection_id'] = $this->input->post('collection_id');
    $collection_type = $this->input->post('collection_type');

    $whereSound['sound_collection_id'] =  $insert['collection_id'];
    if($collection_type != 0){
      $whereSound['sound_type'] = $collection_type;
      $this->session->set_flashdata('selected_sound', $whereSound['sound_type']);
    }
    $sounds = $this->Common_Model->fetch_records('sounds', $whereSound);

    $userdata = $this->Common_Model->fetch_records('users', array('id' => $user_id), false, true);

    // $whereSound = $insert;
    // $totalCredits = $this->Common_Model->fetch_records('sounds', $whereSound, 'SUM(credit_amount) AS total_credit', true);
    $insert['user_id'] = $user_id;

    foreach($sounds as $sound){
      $insert['sound_id'] = $sound['id'];
      unset($insert['created']);
      $where = $insert;
      $checkExist = $this->Common_Model->fetch_records('user_downloads', $where, false, true);

      if($checkExist) continue;

      $insert['created'] = date("Y-m-d H:i:s");
      if($this->Common_Model->insert('user_downloads', $insert)){
        $this->update_wallet($user_id, $sound['credit_amount'], 0);
        $response['status'] = 1;
        $response['responseMessage'] = $this->Common_Model->success('Collection downloaded successfully. Please check <a href="' .site_url('Profile') .'">Downloads</a>');
      }
    }
    $this->session->set_flashdata('responseMessage', $response['responseMessage']);

    echo json_encode($response);
  }

  public function Download_File($fileId, $name){
    if($this->session->userdata('files')){
      $files = $this->session->userdata('files');
      $path = $files[$fileId];
      if(ini_get('zlib.output_compression')) {
        ini_set('zlib.output_compression', 'Off');
      }
      if($path && file_exists($path)){
        // $extension = explode('.', $path);

        // get the file mime type using the file extension
        $this->load->helper('file');

        $mime = get_mime_by_extension($path);

        // Build the headers to push out the file properly.
        // $name = 'auxhole_' .time() .'.' .end($extension);
        header('Pragma: public');     // required
        header('Expires: 0');         // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
        header('Cache-Control: private',false);
        header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
        header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($path)); // provide file size
        header('Connection: close');
        readfile($path); // push it out
        $file[$fileId] = '';
        $this->session->set_userdata('files', $file);
        exit();
      }else{
        redirect('');
      }
    }else{
      redirect('');
    }
  }

}
