<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purifier extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->helper('html_purifier');
    $this->load->helper('security');
  }

  public function purify()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'result' => '',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['input']))
    {
      $response['success'] = TRUE;
      $response['message'] = 'Purified input';
      $response['result'] = html_purify($_POST['input']);
    }

    $json = json_encode($response);
    echo $json;
  }
}
