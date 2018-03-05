<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->model('project_model');
    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('security');
    $this->load->helper('html_purifier');
  }

  public function index($action = 'view', $uri = '')
  {
    session_start();

    if (isset($_SESSION['user']))
    {
      switch ($action)
      {
        case 'view':
          $data = array(
            'base_url' => base_url(),
            'date' => date('d-m-Y'),
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'projects' => html_purify($this->project_model->get_projects())
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
          if ($this->project_model->project_exists($uri))
          {
            $data = html_purify($this->project_model->get_project($uri));

            $data['base_url'] = base_url();
            $data['csrf_name'] = $this->security->get_csrf_token_name();
            $data['csrf_hash'] = $this->security->get_csrf_hash();
            $data['languages'] = $this->project_model->get_languages();

          	$this->parser->parse('backend/projects/update.html', $data);
          }
          else
          {
            show_404();
          }
          break;
        case 'delete':
          $this->delete_projects();
          break;
        case 'search':
          $this->search_projects();
          break;
        default:
          show_404();
          break;
      }
    }
    else
    {
      $url = base_url() . 'index.php/login';

      header('Location: ' . $url);
      exit();
    }
  }

  public function create_project()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['title']))
    {
      $project = array(
        'initiative' => 0,
        'uri' => $this->to_ascii($_POST['title']),
        'thumbnail' => $_POST['thumbnail'],
        'trailer' => $_POST['trailer'],
        'title' => $_POST['title'],
        'subtitle' => $_POST['subtitle'],
        'description' => $_POST['description'],
        'language' => $_POST['language'],
        'date' => $_POST['date']
      );

      if (strlen($project['title']) > 0)
      {
        if (!$this->project_model->project_exists($project['uri']))
        {
          $this->project_model->insert_project($project);

          $response['success'] = TRUE;
          $response['message'] = 'Inserted ' . $project['title'] . 'into database';
        }
        else
        {
          $response['message'] = 'A project with that title already exists';
        }
      }
      else
      {
        $response['title'] = 'Project title cannot be blank';
      }
    }
    else
    {
      $response['message'] = 'No data posted';
    }

    $json = json_encode($response);
    echo $json;
  }

  public function update_project()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'Unspecified error',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['id']))
    {
      // Store both the original and altered information
      // for verification purposes.
      $original = array(
        'uri' => $_POST['original_uri']
      );
      $project = array(
        'id' => $_POST['id'],
        'uri' => $this->to_ascii($_POST['title']),
        'thumbnail' => $_POST['thumbnail'],
        'trailer' => $_POST['trailer'],
        'title' => $_POST['title'],
        'subtitle' => $_POST['subtitle'],
        'description' => $_POST['description'],
        'language' => $_POST['language'],
        'date' => $_POST['date']
      );

      if (strlen($project['title']) > 0)
      {
        if (!$this->project_model->project_exists($project['uri']) OR
            $original['uri'] === $project['uri'])
        {
          $this->project_model->update_project($project);

          $response['success'] = TRUE;
          $response['message'] = 'Project updated successfully';
        }
        else
        {
          $response['message'] = 'Project with that title/URI already exists';
        }
      }
      else
      {
        $response['message'] = 'Project title must not be blank';
      }
    }
    else
    {
      $response['message'] = 'Project data unsent';
    }

    $json = json_encode($response);
    echo $json;
  }

  public function delete_projects()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'Unspecified error',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['projects']))
    {
      $projects = json_decode($_POST['projects']);

      if (sizeof($_POST['projects'] > 0))
      {
        $response['message'] = 'Deleted';

        foreach ($projects as $project)
        {
          $this->project_model->delete_project($project);

          $response['message'] = $response['message'] . ', ' . $project;
        }

        $response['message'] = $response['message'] . ' ' . 'successfully';
        $response['success'] = TRUE;
      }
      else
      {
        $response['message'] = 'Projects to delete must be greater than zero';
      }
    }
    else
    {
      $response['message'] = 'No projects were sent';
    }

    $json = json_encode($response);
    echo $json;
  }

  public function search_projects()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => 'Unspecified error'
    );

    if (isset($_POST['query']))
    {
      $title = $_POST['query'];

      $data = array(
        'projects' => $this->project_model->search_projects($title)
      );

      $response['success'] = TRUE;
      $response['message'] = 'Found some projects from query';

      if (sizeof($data['projects']) > 0)
      {
        $response['html'] = $this->parser->parse(
          'backend/projects/project.html',
          $data,
          TRUE
        );
      }
      else
      {
        $response['html'] = '<em>No projects like "' .
                            htmlentities($title) .
                            '" were found...</em>';
      }
    }
    else
    {
      $response['message'] = '$_POST data unset';
    }

    $json = json_encode($response);
    echo $json;
  }

  // From the 'Perfect Clean URL Generator'
  // Source: http://cubiq.org/the-perfect-php-clean-url-generator

  function to_ascii($str, $replace = array(), $delimiter = '-')
  {
    if (!empty($replace))
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
