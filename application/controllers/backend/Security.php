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
        switch ($action)
        {
          case 'form':
            $this->parser->parse(
              'backend/security/update/credentials.html',
              $data
            );
            break;
          case 'request':
            $response = $this->prepare_response();
            $min_length = array(
              'username' => 4,
              'password' => 16
            );

            if (isset($_POST['username']))
            {
              $username = $_POST['username'];
              $password = $_POST['password'];
              $confirmation = $_POST['password'];

              if (strlen($username) > $min_length['username'] AND
                  strlen($password) > $min_length['password'])
              {
                if (strtolower($username) !== strtolower($password))
                {
                  if ($password === $confirmation)
                  {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    $this->application_model->update(
                      array(
                        'username' => $username,
                        'password' => $hash // Never store passwords in plain text
                      )
                    );

                    $response['success'] = TRUE;
                    $response['message'] = 'Altered user credentials';
                  }
                  else
                  {
                    $response['message'] = 'Password and confirmation don\'t match';
                  }
                }
                else
                {
                  $response['message'] = 'Password cannot be equal to the username';
                }
              }
              else
              {
                $response['message'] = 'Username and/or password is too short';
              }
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
    $data['application_name'] = $this->application_model->get_name();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();

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
