<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screenshots extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->model('screenshot_model');

    $this->load->library('parser');

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
    $data = $this->get_parser_data();
    $data['id'] = $this->screenshot_model->insert($screenshot);

    // Assume that the attempt was successful
    $response['success'] = TRUE;
    $response['message'] = 'Inserted a new screenshot into the database';
    $response['html'] = $this->parser->parse(
      'backend/screenshots/input.html',
      $data,
      TRUE
    );

    $json = json_encode($response);
    echo $json;
  }

  private function prepare_response()
  {
    $response = array(
      'success' => false,
      'message' => 'No error message specified',
      'html' => '',
      'hash' => $this->security->get_csrf_hash()
    );

    return $response;
  }

  private function get_parser_data()
  {
    $data = array(
      'base_url' => base_url(),
      'index_page' => index_page()
    );

    return $data;
  }
}
