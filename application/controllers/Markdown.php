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
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'html' => 'Markdown parse failed',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['input']))
    {
      $html = html_purify(
        markdown_parse($_POST['input'])
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
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
    $this->load->helper('security');
  }
}
