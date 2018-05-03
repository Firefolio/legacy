<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->model('project_model');
    $this->load->model('language_model');

    $this->load->library('parser');

    $this->load->helper('authentication');
    $this->load->helper('url');
    $this->load->helper('uri');
    $this->load->helper('security');
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
  }

  public function index()
  {
    require_authentication();

    $data = array(
      'base_url' => base_url(),
      'date' => date('d-m-Y'),
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
      'projects' => html_purify($this->project_model->get_projects())
    );
    $data['projects'] = $this->clean_project_titles($data['projects']);

    $this->parser->parse('backend/projects/view.html', $data);
  }

  public function create($action = 'form')
  {
    require_authentication();

    switch ($action)
    {
      case 'form':
        $data = array(
          'base_url' => base_url(),
          'csrf_name' => $this->security->get_csrf_token_name(),
          'csrf_hash' => $this->security->get_csrf_hash(),
          'languages' => $this->language_model->get_languages()
        );

        $this->parser->parse('backend/projects/create.html', $data);
        break;
      case 'attempt':
        $response = array(
          'success' => FALSE,
          'message' => 'No error message specified',
          'hash' => $this->security->get_csrf_hash()
        );

        if (isset($_POST['title']))
        {
          $project = get_from_post();

          if (strlen($project['title']) > 0)
          {
            if (!$this->project_model->project_exists($project['uri']))
            {
              $this->project_model->insert_project($project);

              $response['success'] = TRUE;
              $response['message'] = 'Inserted ' .
                                     $project['title'] .
                                     ' into database';
            }
            else
            {
              $response['message'] = 'A project with that title already exists';
            }
          }
          else
          {
            $response['message'] = 'Project title cannot be blank';
          }
        }
        else
        {
          $response['message'] = 'No data posted';
        }

        $json = json_encode($response);
        echo $json;
        break;
      default:
        show_404();
        break;
    }
  }

  public function update($uri = '', $action = 'form')
  {
    require_authentication();

    switch ($action)
    {
      case 'form':
        if ($this->project_model->project_exists($uri))
        {
          // Really, we should use html_purify here,
          // but that could possibly corrupt the data
          $data = $this->project_model->get_project($uri);

          $data['header'] = htmlentities($data['title']);
          $data['preview'] = html_purify(markdown_parse($data['description']));
          $data['base_url'] = base_url();
          $data['csrf_name'] = $this->security->get_csrf_token_name();
          $data['csrf_hash'] = $this->security->get_csrf_hash();
          $data['languages'] = $this->language_model->get_languages();

          $this->parser->parse('backend/projects/update.html', $data);
        }
        else
        {
          show_404();
        }
        break;
      case 'attempt':
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

          $project = get_from_post();

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
        break;
      default:
        show_404();
        break;
    }
  }

  public function delete()
  {
    require_authentication();

    $response = array(
      'success' => FALSE,
      'message' => 'Unspecified error',
      'hash' => $this->security->get_csrf_hash()
    );

    if (isset($_POST['projects']))
    {
      $projects = json_decode($_POST['projects']);

      if (count($_POST['projects'] > 0))
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

  public function search()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => 'Unspecified error'
    );

    if (isset($_POST['input']))
    {
      $title = $_POST['input'];
      $data = array(
        'projects' => $this->project_model->search_projects($title)
      );

      $response['success'] = TRUE;
      $response['message'] = 'Found some projects from query';

      if (count($data['projects']) > 0)
      {
        $data['projects'] = $this->clean_project_titles($data['projects']);
        $response['html'] = $this->parser->parse(
          'backend/projects/list.html',
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
      $response['message'] = '$_POST data unset or no projects exist at all';
    }

    $json = json_encode($response);
    echo $json;
  }

  private function get_from_post()
  {
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

    return $project;
  }

  private function clean_project_titles($projects)
  {
    // Iterate over every project array given to the function
    for ($project = 0; $project < count($projects); $project++)
    {
      // Remove dangerous symbols from each title using htmlentities
      $dirty_title = $projects[$project]['title'];
      $clean_title = htmlentities($dirty_title);
      $projects[$project]['title'] = $clean_title;
    }

    return $projects;
  }
}
