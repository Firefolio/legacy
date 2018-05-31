<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purifier extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->helper('html_purifier');
  }

  public function purify()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'result' => ''
    );

    if (isset($_POST['input']))
    {
      $response['success'] = TRUE;
      $response['message'] = TRUE;
      $response['result'] = html_purify($_POST['input']);
    }

    $json = json_encode($response);
    echo $json;
  }
}
