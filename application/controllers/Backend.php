<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->model('project_model');
    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('security');
  }

  public function projects($action = 'view', $uri = '')
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
              $this->project_model->get_projects()
            )
          );

          $this->parser->parse('backend/projects/view.html', $data);
          break;
        case 'create':
          $data = array(
            'base_url' => base_url(),
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'languages' => $this->project_model->get_languages()
          );

          $this->parser->parse('backend/projects/create.html', $data);
          break;
        case 'update':
          $data = $this->security->xss_clean(
            $this->project_model->get_project($uri)
          );

          $data['base_url'] = base_url();
          $data['date'] = date(
            'd-m-Y',
            strtotime($data['date'])
          );

        	$this->parser->parse('backend/projects/update.html', $data);;
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
        'uri' => $this->to_ascii($_POST['title']),
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

  // From the Perfect Clean URL Generator
  // Source: http://cubiq.org/the-perfect-php-clean-url-generator

  function to_ascii($str, $replace = array(), $delimiter = '-')
  {
    if(!empty($replace))
    {
      $str = str_replace((array)$replace, ' ', $str);
    }

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
  }
}
