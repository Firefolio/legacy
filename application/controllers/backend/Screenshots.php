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
      'backend/screenshots/input/single.html',
      $data,
      TRUE
    );

    $json = json_encode($response);
    echo $json;
  }

  public function update()
  {
    $response = $this->prepare_response();

    if (isset($_POST['screenshots']))
    {
      $screenshots = json_decode($_POST['screenshots']);

      foreach ($screenshots as $screenshot)
      {
        $this->screenshot_model->update($screenshot);
      }

      $response['success'] = TRUE;
      $response['message'] = 'Updated given screenshots';
    }
    else
    {
      $response['message'] = 'No data sent to server';
    }

    $json = json_encode($response);
    echo $json;
  }

  public function delete()
  {
    $response = $this->prepare_response();

    if (isset($_POST['id']))
    {
      $screenshot = $_POST['id'];

      $this->screenshot_model->delete($screenshot);

      $response['success'] = true;
      $response['message'] = 'Removed screenshot ' .
                            $screenshot .
                            ' from the database';
    }
    else
    {
      $response['message'] = 'No ID sent to server';
    }

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
      'index_page' => index_page(),
      'path' => '',
      'caption' => ''
    );

    return $data;
  }
}
