<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->model('profile_model');
    $this->load->model('application_model');

    $this->load->library('parser');

    $this->load->helper('authentication');
    $this->load->helper('url');
    $this->load->helper('security');
  }

  public function index()
  {
    require_authentication();

    $this->parser->parse(
      'backend/profile/update.html', // View
      $this->get_parser_data() // Data
    );
  }

  public function update()
  {
    require_authentication();

    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['first_name']))
    {
      $this->profile_model->update_profile($this->get_post_data());

      $response['success'] = TRUE;
      $response['message'] = 'Profile updated successfully';
    }
    else
    {
      $response['message'] = 'No profile data sent';
    }

    $json = json_encode($response);
    echo $json;
  }

  private function get_post_data()
  {
    $data = array(
      'first_name' => $_POST['first_name'] ?? '',
      'middle_name' => $_POST['middle_name'] ?? '',
      'last_name' => $_POST['last_name'] ?? ''
    );

    return $data;
  }

  private function get_parser_data()
  {
    $data = $this->profile_model->get_profile();
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();
    $data['application_name'] = $this->application_model->get_name();
    $data['major_version'] = $this->application_model->get_major_version();
    $data['minor_version'] = $this->application_model->get_minor_version();
    $data['patch'] = $this->application_model->get_patch();
    $data['website'] = $this->application_model->get_website();
    $data['navbar'] = $this->parser->parse(
      'backend/navbar.html',
      $data,
      TRUE
    );

    return $data;
  }
}
