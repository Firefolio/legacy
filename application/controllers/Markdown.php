<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Markdown extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function parse()
  {
    $response = $this->prepare_response();

    if (isset($_POST['description']))
    {
      $html = html_purify(
        markdown_parse($_POST['description'])
      );

      $response['success'] = TRUE;
      $response['message'] = 'Parsed Markdown successfully!';
      $response['html'] = $html;
    }
    else
    {
      $response['message'] = 'No markdown code sent to server';
    }

    $json = json_encode($response);
    echo $json;
  }

  private function load_assets()
  {
    // Helpers
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
    $this->load->helper('security');
  }

  private function prepare_response()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'html' => 'Markdown code could not be parsed',
      'hash' => $this->security->get_csrf_hash()
    );

    return $response;
  }
}
