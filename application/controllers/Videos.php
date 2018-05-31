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
      'html' => '',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['url']))
    {
      $response['success'] = TRUE;
      $response['message'] = 'Purified input';
      $response['html'] = $this->video->embed($_POST['url'], TRUE);
    }

    $json = json_encode($response);
    echo $json;
  }

  private function load_assets()
  {
    $this->load->helper('html_purifier');
    $this->load->helper('security');
    $this->load->library('video');
  }
}
