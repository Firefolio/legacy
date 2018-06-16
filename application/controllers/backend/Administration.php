<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function index()
  {
    require_authentication();
    validate_user_credentials();

    $data = $this->get_parser_data();

    $this->parser->parse('backend/administration/update.html', $data);
  }

  public function update($target)
  {
    require_authentication();

    switch ($target)
    {
      case 'username':
        $response = array(
          'success' => FALSE,
          'message' => 'No error message specified',
          'hash' => $this->security->get_csrf_hash()
        );

        if (isset($_POST['username']))
        {
          $username = $_POST['username'];
          $minimum_length = 4;

          // The username must be greater than the minimum length
          if (strlen($username) > $minimum_length)
          {
            $this->application_model->update_username($username);

            $response['success'] = TRUE;
            $response['message'] = 'Changed username';
          }
          else
          {
            $response['message'] = 'New username is too short';
          }
        }
        else
        {
          $response['message'] = 'No username posted';
        }

        $json = json_encode($response);
        echo $json;
        break;
      case 'password':
        $response = array(
          'success' => FALSE,
          'message' => 'No error message specified',
          'hash' => $this->security->get_csrf_hash()
        );

        if (isset($_POST['password']) AND isset($_POST['confirmation']))
        {
          $password = $_POST['password'];
          $confirmation = $_POST['confirmation'];

          if ($password === $confirmation)
          {
            $minimum_length = 16;

            if (strlen($password) > $minimum_length)
            {
              $hash = password_hash($password, PASSWORD_DEFAULT);

              $this->application_model->update_password($hash);

              $response['success'] = TRUE;
              $response['message'] = 'Changed password';
            }
            else
            {
              $response['message'] = 'New username is too short';
            }
          }
          else
          {
            $response['message'] = 'Password and confirmation don\'t match';
          }
        }
        else
        {
          $response['message'] = 'No password posted';
        }

        $json = json_encode($response);
        echo $json;
        break;
      default:
        show_404();
        break;
    }
  }

  private function load_assets()
  {
    // Models
    $this->load->model('application_model');
    $this->load->model('project_model');
    $this->load->model('profile_model');
    $this->load->model('screenshot_model');
    $this->load->model('hyperlink_model');
    // Helpers
    $this->load->helper('authentication');
    $this->load->helper('backup');
    $this->load->helper('credentials');
    $this->load->helper('form');
    $this->load->helper('url');
    $this->load->helper('security');
    // Libraries
    $this->load->library('parser');
  }

  private function get_parser_data()
  {
    $data = $this->application_model->get();
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();
    $data['application_name'] = $this->application_model->get_name();
    $data['major_version'] = $this->application_model->get_major_version();
    $data['minor_version'] = $this->application_model->get_minor_version();
    $data['patch'] = $this->application_model->get_patch();
    $data['website'] = $this->application_model->get_website();
    $data['navbar'] = $this->parser->parse('backend/navbar.html', $data, TRUE);
    $data['stylesheets'] = $this->parser->parse('backend/stylesheets.html', $data, TRUE);
    $data['restoration_form'] = form_open_multipart('backend/administration/restore');

    return $data;
  }
}
