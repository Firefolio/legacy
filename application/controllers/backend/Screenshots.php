<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screenshots extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->model('screenshot_model');

    $this->load->helper('html_purifier');
    $this->load->helper('security');
    $this->load->helper('url');
  }

  public function insert($project)
  {
    $response = $this->prepare_response();
    $screenshot = array(
      'project' => $project
    );

    $this->screenshot_model->insert($screenshot);

    $json = json_encode($response);
    return $json;
  }

  private function prepare_response()
  {
    $response = array(
      'success' => false,
      'message' => 'No error message specified',
      'html' => ''
    );

    return $response;
  }
}
