<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markdown extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
  }

  public function parse()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'html' => '<p>Markdown parse failed</p>'
    );

    if (isset($_POST['data'])) {
      'success' => TRUE,
      $response['html'] = markdown_parse($_POST['input']);
    }

    $json = json_encode($response);
    echo $json;
  }
}
