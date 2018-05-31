<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function get_thumbnail()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'result' => '',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['url']))
    {
      $response['success'] = TRUE;
      $response['message'] = 'Got thumbnail path';
      $response['result'] = $this->video->get_thumbnail($_POST['url']);
    }

    $json = json_encode($response);
    echo $json;
  }

  private function load_assets()
  {
    // Helpers
    $this->load->helper('html_purifier');
    $this->load->helper('security');
    // Libraries
    $this->load->library('video');
  }
}
