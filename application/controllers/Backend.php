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
            'date' => date('d-m-Y'),
            'projects' => $this->security->xss_clean(
              $this->portfolio_model->get_projects()
            )
          );

          $this->parser->parse('backend/projects/view.html', $data);
          break;
        case 'create':
          $data = array(
            'base_url' => base_url(),
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'languages' => $this->portfolio_model->get_languages()
          );

          $this->parser->parse('backend/projects/create.html', $data);
          break;
        case 'delete':
          // Add deletion code here
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

  public function create_project()
  {
    if (isset($_POST))
    {
      $project = array(
        'initiative' => 0,
        'uri' => urlencode($_POST['title']),
        'title' => $_POST['title'],
        'subtitle' => $_POST['subtitle'],
        'description' => $_POST['description'],
        'language' => $_POST['language'],
        'date' => $_POST['date']
      );
      $this->db->insert('projects', $project);

      $url = '../view';

      header('Location: ' . $url);
      exit();
    }
    else
    {
      $url = '../';

      header('Location: ' . $url);
      exit();
    }
  }
}
