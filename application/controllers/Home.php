<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
    $businessData = $this->Common_Model->fetch_records('business_details');
    $businessData = $businessData[0];

    return array('businessData' => $businessData);
  }

  public function index(){
    $pageData = $this->get_userdata();
    $pageData['services'] = $this->Common_Model->fetch_records('services', array('is_deleted' => 0));
    // $pageData['plans'] = $this->Common_Model->fetch_records('plans');
    // $pageData['banners'] = $this->Common_Model->fetch_records('home_banners');
    $this->load->view('site/index', $pageData);
  }

  public function contact(){
    $pageData = $this->get_userdata();
    $this->load->view('site/contact_us', $pageData);
  }

  public function covid_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/covid_details', $pageData);
  }

  public function electrical_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/electrical_details', $pageData);
  }

  public function transformer_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/transformer_details', $pageData);
  }

  public function panel_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/panel_details', $pageData);
  }

  public function furniture_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/furniture_details', $pageData);
  }

  public function carpenter_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/carpenter_details', $pageData);
  }

  public function fire_details(){
    $pageData = $this->get_userdata();
    $this->load->view('site/fire_details', $pageData);
  }

  public function about(){
    $pageData = $this->get_userdata();
    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/include/about_us', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function services(){
    $pageData = $this->get_userdata();
    $pageData['services'] = $this->Common_Model->fetch_records('services', array('is_deleted' => 0));
    $this->load->view('site/include/header', $pageData);
    $this->load->view('site/include/services', $pageData);
    $this->load->view('site/include/footer', $pageData);
  }

  public function service($id){
    $pageData = $this->get_userdata();
    $pageData['serviceDetails'] = $this->Common_Model->fetch_records('services', array('id' => $id, 'is_deleted' => 0), false, true);
    $pageData['serviceImages'] = $this->Common_Model->fetch_records('service_images', array('service_id' => $id, 'is_deleted' => 0));
    $pageData['serviceBrochures'] = $this->Common_Model->fetch_records('service_brochures', array('service_id' => $id, 'is_deleted' => 0));

    $this->load->view('site/service_details', $pageData);
  }

  public function request(){
    $this->load->helper(array('form', 'url'));

    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('phone', 'phone', 'required');
    $this->form_validation->set_rules('query', 'query', 'required');
    if ($this->form_validation->run()){
      $insert = $this->input->post();
      $insert['created'] = date('Y-m-d H:i:s');
      if($this->Common_Model->insert('contact_requests', $insert)){
        $adminData = $this->Common_Model->fetch_records('business_details', array('id' => 1));
        $adminData = $adminData[0];
        $subject = 'New request received';
        $this->Common_Model->send_mail_new($insert['email'], $subject, $insert['query']);

        $responseClass = 'success';
        $responseMessage = 'Request Sent Successfully.';
      }
    }else{
      $responseClass = 'danger';
      $responseMessage = validation_errors();
    }
    $formResponse = "<div class='row'>
                  <div class='col-sm-12'>
                    <div class='alert alert-$responseClass alert-dismissible'>
          <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
          $responseMessage
        </div>
      </div>
    </div>";
    $this->session->set_flashdata('formResponse', $formResponse);

    redirect('Contact');
  }
  /* No need below this */

  public function community(){
    $pageData = $this->get_userdata();
    $this->load->view('site/community', $pageData);
  }

  public function sounds($id){
    $pageData = $this->get_userdata();
    $where['id'] = $id;
    $pageData['categoryDetails'] = $this->Common_Model->fetch_records('categories', $where, false, true);
    if($pageData['categoryDetails']['parent_category'] != 0){
      redirect('Sounds/' .$pageData['categoryDetails']['parent_category']);
    }

    $pageData['currentCategoryId'] = $id;

    $whereSubCategory['parent_category'] = $id;
    $pageData['subCategories'] = $this->Common_Model->fetch_records('categories', $whereSubCategory);

    $this->load->view('site/sounds', $pageData);
  }

  public function sound_details($id){
    $pageData = $this->get_userdata();

    $where['id'] = $id;
    $pageData['categoryDetails'] = $this->Common_Model->fetch_records('categories', $where, false, true);

    if(empty($pageData['categoryDetails'])){
      redirect('');
    }
    if($pageData['categoryDetails']['parent_category'] == 0){
      redirect('Sounds/' .$pageData['categoryDetails']['id']);
    }

    $whereParentCategory['id'] = $pageData['categoryDetails']['parent_category'];
    $pageData['parentCategoryDetails'] = $this->Common_Model->fetch_records('categories', $whereParentCategory, false, true);

    $whereSound['sound_sub_category'] = $id;
    $pageData['categorySounds'] = $this->Common_Model->fetch_records('sounds', $whereSound);

    if(!empty($pageData['userdata'])){
      foreach($pageData['categorySounds'] as $key => $categorySound){
        $whereIsLiked['user_id'] = $pageData['userdata']['id'];
        $whereIsLiked['sound_id'] = $categorySound['id'];
        $isLikeExists = $this->Common_Model->fetch_records('sound_likes', $whereIsLiked, false, true);
        $pageData['categorySounds'][$key]['is_liked'] = ($isLikeExists) ? 1 : 0;
      }
    }

    $whereSubCategory['id !='] = $id;
    $pageData['sliderSubCategories'] = $this->Common_Model->fetch_records('categories', $whereSubCategory);
    $pageData['subCategoryId'] = $id;

    $this->load->view('site/sound-detail', $pageData);
  }

  public function blogs($id){
    if($id != 1 && $id != 2) redirect('Blogs/1');
    $pageData = $this->get_userdata();
    $where['is_deleted'] = 0;
    $where['blog_category'] = $id;
    $pageData['blogs'] = $this->Common_Model->fetch_records('blogs', $where, false, false, 'id');
    $this->load->view('site/blogs', $pageData);
  }

  public function blog_details($id){
    $pageData = $this->get_userdata();
    $where['is_deleted'] = 0;
    $where['id'] = $id;
    $pageData['blogDetails'] = $this->Common_Model->fetch_records('blogs', $where, false, true);
    $whereRecent['is_deleted'] = 0;
    $whereRecent['id != '] = $id;
    $pageData['recentBlogs'] = $this->Common_Model->fetch_records('blogs', $whereRecent, false, false, false, false, false, false, false, 3);

    if(empty($pageData['blogDetails'])){
      redirect('Blogs/1');
    }
    $this->load->view('site/blog-details', $pageData);
  }

  public function collections($id){
    $pageData = $this->get_userdata();
    $where['id'] = $id;
    $pageData['categoryDetails'] = $this->Common_Model->fetch_records('categories', $where, false, true);
    if($pageData['categoryDetails']['parent_category'] == 0){
      redirect('');
    }

    $whereSubCategories['parent_category !='] = 0;
    $pageData['subCategories'] = $this->Common_Model->fetch_records('categories', $whereSubCategories);

    $pageData['currentCategoryId'] = $id;

    $whereCollections['sub_category_id'] = $id;
    $pageData['collections'] = $this->Common_Model->fetch_records('collections', $whereCollections);

    $this->load->view('site/collections', $pageData);
  }

  public function collection_details($id){
    $pageData = $this->get_userdata();

    $pageData['selectedSound'] = $this->session->flashdata('selected_sound');
    $pageData['downloaded'] = ($pageData['selectedSound']) ? 1 : 0;

    $where['id'] = $id;
    $pageData['collectionDetails'] = $this->Common_Model->fetch_records('collections', $where, false, true);

    if(empty($pageData['collectionDetails'])){
      redirect('');
    }

    $whereSound['sound_collection_id'] = $id;
    $pageData['collectionSounds'] = $this->Common_Model->fetch_records('sounds', $whereSound);

    $totalCredits = $this->Common_Model->fetch_records('sounds', $whereSound, 'SUM(credit_amount) AS total_credit', true);

    $alreadyPurchased = 0;
    if(!empty($pageData['userdata'])){
      foreach($pageData['collectionSounds'] as $key => $categorySound){
        $whereIsLiked['user_id'] = $pageData['userdata']['id'];
        $whereIsLiked['sound_id'] = $categorySound['id'];
        $isLikeExists = $this->Common_Model->fetch_records('sound_likes', $whereIsLiked, false, true);
        $pageData['collectionSounds'][$key]['is_liked'] = ($isLikeExists) ? 1 : 0;

        $isDownloadExists = $this->Common_Model->fetch_records('user_downloads', $whereIsLiked, false, true);
        $pageData['collectionSounds'][$key]['is_downloaded'] = ($isDownloadExists) ? 1 : 0;
        $alreadyPurchased += ($isDownloadExists) ? $categorySound['credit_amount'] : 0;
      }
    }
    $pageData['totalCredits'] = $totalCredits['total_credit'] - $alreadyPurchased;

    if(!empty($pageData['userdata'])){
      $pageData['creditAvailable'] = ($pageData['userdata']['total_credits'] >= $pageData['totalCredits']) ? 1 : 0;
    }

    $whereCollections['id !='] = $id;
    $pageData['sliderCollections'] = $this->Common_Model->fetch_records('collections', $whereCollections);
    $pageData['collectionId'] = $id;

    $this->load->view('site/collection-sound-detail', $pageData);
  }

  public function get_collection_sounds(){
    $pageData = $this->get_userdata();

    $pageData['collection_sound_type'] = 0;
    $whereSound['sound_collection_id'] = $this->input->post('collection_id');
    $sound_type = $this->input->post('sound_type');
    if(trim($sound_type)){
      $whereSound['sound_type'] = $sound_type;
      $pageData['collection_sound_type'] = $sound_type;
    }
    $pageData['collectionSounds'] = $this->Common_Model->fetch_records('sounds', $whereSound);

    $totalCredits = $this->Common_Model->fetch_records('sounds', $whereSound, 'SUM(credit_amount) AS total_credit', true);

    $alreadyPurchased = 0;
    if(!empty($pageData['userdata'])){
      foreach($pageData['collectionSounds'] as $key => $categorySound){
        $whereIsLiked['user_id'] = $pageData['userdata']['id'];
        $whereIsLiked['sound_id'] = $categorySound['id'];
        $isLikeExists = $this->Common_Model->fetch_records('sound_likes', $whereIsLiked, false, true);
        $pageData['collectionSounds'][$key]['is_liked'] = ($isLikeExists) ? 1 : 0;

        $isDownloadExists = $this->Common_Model->fetch_records('user_downloads', $whereIsLiked, false, true);
        $pageData['collectionSounds'][$key]['is_downloaded'] = ($isDownloadExists) ? 1 : 0;
        $alreadyPurchased += ($isDownloadExists) ? $categorySound['credit_amount'] : 0;
      }
    }
    $pageData['totalCredits'] = $totalCredits['total_credit'] - $alreadyPurchased;

    $this->load->view('site/include/sounds-list', $pageData);
  }

  public function open_player(){

    echo json_encode($response);
  }

  public function player(){
    $whereSound['sound_collection_id'] = $this->input->post('collection_id');
    if(!$whereSound['sound_collection_id'] && $this->session->userdata('is_playing')){
      $whereSound['sound_collection_id'] = $this->session->userdata('is_playing');
    }else{
      $this->session->set_userdata('is_playing', $whereSound['sound_collection_id']);
    }
    $whereSound['sound_type !='] = 3;

    $pageData['sound_collection_id'] = $whereSound['sound_collection_id'];
    $pageData['collectionSounds'] = $this->Common_Model->fetch_records('sounds', $whereSound, 'CONCAT("' .site_url() .'", sound_file) AS path, sound_title AS displayName, CONCAT("' .site_url() .'", sound_artwork) AS cover');

    $this->load->view('site/player', $pageData);
  }

  public function index_player(){
    $banners = $this->Common_Model->fetch_records('home_banners');
    $soundIds = [];
    $collections = [];
    foreach($banners as $banner){
      $collections[$banner['sound_id']] = $banner['collection_id'];
      $soundIds[] = $banner['sound_id'];
    }

    $this->db->select('CONCAT("' .site_url() .'", sound_file) AS path, sound_title AS displayName, CONCAT("' .site_url() .'", sound_artwork) AS cover, id');
    // $this->db->select('sound_file AS path, sound_title AS displayName, CONCAT("' .site_url() .'", sound_artwork) AS cover, id');
    $this->db->from('sounds');
    $this->db->where('sound_type !=', 3);
    $this->db->where_in('id', $soundIds);
    $query = $this->db->get();
    $collectionSounds = $query->result_array();
    $pageData['collectionSounds'] = [];
    foreach($collectionSounds as $key => $collectionSound){
      $collectionSounds[$key]['collection_id'] = $collections[$collectionSound['id']];
      // $soundFile = file_get_contents($collectionSound['path']);
      // $blobFile = base64_encode($soundFile);
      // $collectionSounds[$key]['path'] = $blobFile;
    }
    $pageData['collectionSounds'] = $collectionSounds;
    $pageData['sound_collection_id'] = $collectionSounds[0]['collection_id'];

    $this->load->view('site/player', $pageData);
  }

  public function faqs(){
    $pageData = $this->get_userdata();
    $this->load->view('site/faqs', $pageData);
  }

  public function terms(){
    $pageData = $this->get_userdata();
    $this->load->view('site/terms_page', $pageData);
  }

  public function payment(){
    $pageData = $this->get_userdata();
    $this->load->view('site/payment_option', $pageData);
  }

  public function tips(){
    $pageData = $this->get_userdata();
    $this->load->view('site/booking_tips');
  }

  public function works(){
    $pageData = $this->get_userdata();
    $this->load->view('site/how_it_works', $pageData);
  }

  public function profile(){
    $pageData = $this->get_userdata();
    $this->load->view('site/myprofile', $pageData);
  }

  public function partner(){
    $pageData = $this->get_userdata();
    $this->load->view('site/partner');
  }

  public function policy(){
    $pageData = $this->get_userdata();
    $this->load->view('site/policy', $pageData);
  }

  public function price(){
    $pageData = $this->get_userdata();
    $this->load->view('site/price', $pageData);
  }

  public function test_function(){
     if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

      // get the file mime type using the file extension
      $this->load->helper('file');

      $path = 'assets/site/sounds/10082593331608725453.wav';
      $mime = get_mime_by_extension($path);

      // Build the headers to push out the file properly.
      $name = 'mp3_file.wav';
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
      exit();
  }

}
