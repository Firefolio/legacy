<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
    $this->load->library('parser');
    $this->load->model('user_model');
  }

  public function form()
  {
    $data = array('base_url' => base_url());
    $this->parser->parse('backend/login.html', $data);
  }

  public function login()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified'
    );
    $user = $this->user_model->get_user();

    if (isset($_POST))
    {
      if (isset($_POST['username']) AND
          isset($_POST['password']))
      {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (strlen($username) > 0 AND
            strlen($password) > 0)
        {
          if ($username === $user->username AND
              password_verify($password, $user->password))
          {
            session_start();
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
    }
    else
    {
      $response['message'] = 'No values posted at all';
    }

    $json = json_encode($response);
    echo $json;
  }

  public function logout()
  {
    session_start();
    unset($_SESSION['user']);

    $url = base_url() . 'index.php/login';

    header('Location: ' . $url);
  }
}
