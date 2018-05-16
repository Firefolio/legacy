<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model('application_model');

    $this->load->helper('url');
    $this->load->helper('security');

    $this->load->library('parser');
  }

  public function index()
  {
    session_start();

    if (!isset($_SESSION['user']))
    {
      $data = array(
        'base_url' => base_url(),
        'index_page' => index_page(),
        'application_name' => $this->application_model->get_name(),
        'csrf_name' => $this->security->get_csrf_token_name(),
        'csrf_hash' => $this->security->get_csrf_hash()
      );

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
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash()
    );
    $credentials = $this->application_model->get_credentials();

    session_start();

    if (isset($_POST['username']) && isset($_POST['password']))
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
          $response['message'] = 'Incorrect login credentials';
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
}
