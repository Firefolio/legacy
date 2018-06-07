<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function update($what = 'credentials', $action = 'form')
  {
    require_authentication();

    $data = $this->get_parser_data();

    switch ($what)
    {
      case 'credentials':
        switch ($credentials)
        {
          case 'form':
            $this->parser->parse(
              'backend/security/update/credentials.html',
              $data
            );
            break;
          case 'request':
            $respsonse = $this->prepare_response();

            if (isset($_POST['username']))
            {
              
            }
            else
            {
              $response['message'] = 'No post data received';
            }

            $json = json_encode($response);
            echo $json;
            break;
          default:
            show_404();
            break;
        }
        break;
      default:
        show_404();
        break;
    }
  }

  private function get_parser_data()
  {
    $data = array();
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['navbar'] = $this->parser->parse(
      'backend/navbar.html',
      $data,
      TRUE
    );

    return $data;
  }

  private function prepare_response()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => ''
    );

    return $response;
  }

  private function load_assets()
  {
    // Models
    $this->load->model('application_model');
    // Libraries
    $this->load->library('parser');
    // Helpers
    $this->load->helper('authentication');
    $this->load->helper('credentials');
    $this->load->helper('url');
    $this->load->helper('security');
  }
}
