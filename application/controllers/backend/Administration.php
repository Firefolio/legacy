<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->model('user_model');
    $this->load->model('application_model');

    $this->load->helper('url');
    $this->load->helper('security');

    $this->load->library('parser');
  }

  public function index()
  {
    session_start();

    if (isset($_SESSION['user']))
    {
      $data = $this->get_parser_data();

      $this->parser->parse('backend/administration/update.html', $data);
    }
    else
    {
      $url = base_url() . 'index.php/login';
      header('Location: ' . $url);
      exit();
    }
  }

  public function update($target)
  {
    switch ($target)
    {
      case 'username':
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
            $minimum_length = 8;

            if (strlen($password) >= $minimum_length)
            {
              $this->user_model->update_password($password);

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

        if (isset($_POST['username']))
        {
          $username = $_POST['username'];

          if (strlen($username) >= 3)
          {
            $this->user_model->update_username($username);

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
      default:
        show_404();
        break;
    }
  }

  private function get_parser_data()
  {
    $data = $this->user_model->get_user();
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
