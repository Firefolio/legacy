<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function index()
  {
    session_start();

    // Only show the login form if the user hasn't been authenticated already
    if (!isset($_SESSION['user']))
    {
      $data = $this->get_parser_data();

      $this->parser->parse('backend/login.html', $data);
    }
    else
    {
      $url = base_url() . index_page() . '/backend/projects';

      header('Location: ' . $url);
      exit();
    }
  }

  public function attempt()
  {
    session_start();

    $response = $this->prepare_response();
    $credentials = $this->application_model->get_credentials();

    if (isset($_POST['username']) AND isset($_POST['password']))
    {
      $username = $_POST['username'];
      $password = $_POST['password'];

      if (strlen($username) > 0 AND strlen($password) > 0)
      {
        if ($username === $credentials['username'] AND
            password_verify($password, $credentials['password']))
        {
          $_SESSION['user'] = $username;

          $response['success'] = TRUE;
          $response['message'] = 'Login attempt successful';
        }
        else
        {
          $response['message'] = 'Login credentials are incorrect';
        }
      }
      else
      {
        $response['message'] = 'Login credentials contain blank fields';
      }
    }
    else
    {
      $response['message'] = 'Login credentials not recieved';
    }

    // Return the result of the AJAX request in JSON
    $json = json_encode($response);
    echo $json;
  }

  /**
  * Logs the user out of the backend and destroys the session variable
  */
  public function logout()
  {
    session_start();
    unset($_SESSION['user']);

    $url = base_url() . index_page() . '/login';

    header('Location: ' . $url);
  }

  private function load_assets()
  {
    // Models
    $this->load->model('application_model');

    // Helpers
    $this->load->helper('url');
    $this->load->helper('security');

    // Libraries
    $this->load->library('parser');
  }

  private function prepare_response()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash()
    );

    return $response;
  }

  public function get_parser_data()
  {
    $data = array();
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['application_name'] = $this->application_model->get_name();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();
    $data['stylesheets'] = $this->parser->parse('backend/stylesheets.html', $data, TRUE);

    return $data;
  }
}
