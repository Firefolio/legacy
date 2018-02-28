<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->model('profile_model');
    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('security');
  }

  public function index()
  {
    $data = array(
      'base_url' => base_url(),
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
      'first_name' => $this->profile_model->get_first_name(),
      'middle_name' => $this->profile_model->get_middle_name(),
      'last_name' => $this->profile_model->get_last_name(),
    );

    $this->parser->parse('backend/profile/update.html', $data);
  }

  public function update()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['first_name']) AND
        isset($_POST['middle_name']) AND
        isset($_POST['last_name']))
    {
      $first_name = $_POST['first_name'];
      $middle_name = $_POST['middle_name'];
      $last_name = $_POST['last_name'];

      $this->profile_model->update_profile(
        array(
          'first_name' => $first_name,
          'middle_name' => $middle_name,
          'last_name' => $last_name
        )
      );

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
}
