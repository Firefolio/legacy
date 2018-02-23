<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('security');
    $this->load->model('portfolio_model');
  }

  public function projects($action = 'view')
  {
    // Require user authentication
    session_start();

    if (isset($_SESSION['user']))
    {
      switch ($action)
      {
        case 'view':
          $data = array(
            'base_url' => base_url(),
            'projects' => $this->security->xss_clean(
              $this->portfolio_model->get_projects()
            )
          );

          $this->parser->parse('backend/projects/projects.html', $data);
          break;
        case 'create':
          $data = array(
            'base_url' => base_url(),
            'projects' => $this->security->xss_clean(
              $this->portfolio_model->get_projects()
            )
          );

          $this->parser->parse('backend/projects/create.html', $data);
          break;
        default:
          show_404();
          break;
      }
    }
    else
    {
      $url = 'login';

      header('Location: ' . $url);
      exit();
    }
  }
}
