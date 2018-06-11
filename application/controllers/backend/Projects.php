<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function index()
  {
    require_authentication();
    validate_user_credentials();

    $data = $this->get_parser_data();

    if (!empty($data['projects']))
    {
      $data['projects'] = $this->clean_project_titles(
        html_purify($data['projects'])
      );
    }

    $data['project_list'] = $this->parser->parse(
      'backend/projects/list.html',
      $data,
      TRUE
    );

    // Include URL data in each project for the parser
    for ($project = 0; $project < count($data['projects']); $project++)
    {
      $data['projects'][$project]['base_url'] = base_url();
      $data['projects'][$project]['index_page'] = index_page();
    }

    $this->parser->parse('backend/projects/view.html', $data);
  }

  public function create($action = 'form')
  {
    require_authentication();
    backup_database();

    switch ($action)
    {
      case 'form':
        validate_user_credentials();

        $destination = base_url() .
                       index_page() .
                       '/backend/projects/create/attempt';
        $redirect = base_url() . index_page() . '/backend/projects';

        $data = $this->get_parser_data();
        $data['form'] = $this->get_form($destination, $redirect);

        $this->parser->parse('backend/projects/create.html', $data);
        break;
      case 'attempt':
        $response = $this->prepare_response();

        if (isset($_POST['title']))
        {
          $project = $this->get_post_data();

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
          validate_user_credentials();

          // Define where the form will send it's data
          $destination = base_url() .
                         index_page() .
                         '/backend/projects/update/' .
                         $uri .
                         '/attempt';
          // Define where the page will redirect to once submitted
          $redirect = base_url() . index_page() . '/backend/projects';

          // Really, we should use html_purify on everything here,
          // but that could possibly corrupt the data input
          $data = $this->get_parser_data($uri);

          // Instead, we configure each output manually
          $data['header'] = htmlentities(
            $data['title'],
            ENT_QUOTES
          );
          $data['form'] = $this->get_form($destination, $redirect, $uri);

          $this->parser->parse('backend/projects/update.html', $data);
        }
        else
        {
          show_404();
        }
        break;
      case 'attempt':
        backup_database();

        $response = $this->prepare_response();

        if (isset($_POST['id']))
        {
          // Store both the original and altered information
          // for verification purposes.
          $original = array(
            'uri' => $_POST['original_uri']
          );

          $project = $this->get_post_data();

          if (strlen($project['title']) > 0)
          {
            if (!$this->project_model->project_exists($project['uri']) OR
                $original['uri'] === $project['uri'])
            {
              $this->project_model->update_project($project);

              $response['success'] = TRUE;
              $response['message'] = 'Project updated successfully';

              backup_database();
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
    backup_database();

    $response = $this->prepare_response();

    if (isset($_POST['projects']))
    {
      $projects = $_POST['projects'];

      if (count($_POST['projects'] > 0))
      {
        // The response's message will be expanded as projects are deleted
        $response['message'] = 'Deleted';

        foreach ($projects as $project)
        {
          $this->project_model->delete_project($project);

          $response['message'] = $response['message'] . ', ' . $project;
        }

        $response['message'] = $response['message'] . ' successfully';
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
    $response = $this->prepare_response();

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
                            htmlentities(
                              $title,
                              ENT_QUOTES
                            ) .
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

  public function load_assets()
  {
    // Models
    $this->load->model('application_model');
    $this->load->model('project_model');
    $this->load->model('screenshot_model');
    $this->load->model('hyperlink_model');
    // Libraries
    $this->load->library('parser');
    $this->load->library('video');
    // Helpers
    $this->load->helper('authentication');
    $this->load->helper('credentials');
    $this->load->helper('backup');
    $this->load->helper('url');
    $this->load->helper('uri');
    $this->load->helper('security');
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
  }

  private function get_parser_data($uri = '')
  {
    // WARNING: the following function does not purify user output on its own.
    // Use htmlentities and html_purify to prevent XSS attacks from user data!

    // Determine whether a single project, or multiple projects are needed
    if ($uri != '')
    {
      // Single project
      $data = $this->project_model->get_project($uri);
      $data['screenshots'] = $this->get_screenshots($data['id']);
      $data['hyperlinks'] = $this->get_hyperlinks($data['id']);
    }
    else
    {
      // Multiple projects
      // Also get blank project data in case it's used on its own
      $data = $this->project_model->get_project();
      $data['projects'] = $this->get_projects();
    }

    // Then add all of the other data we might need on top
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();
    $data['application_name'] = $this->application_model->get_name();
    $data['major_version'] = $this->application_model->get_major_version();
    $data['minor_version'] = $this->application_model->get_minor_version();
    $data['patch'] = $this->application_model->get_patch();
    $data['website'] = $this->application_model->get_website();
    // The navigation bar should be parsed last because it
    // relies on the above information
    $data['navbar'] = $this->parser->parse('backend/navbar.html', $data, TRUE);
    $data['stylesheets'] = $this->parser->parse('backend/stylesheets.html', $data, TRUE);
    $data['visibilities'] = $this->project_model->get_visibilities();
    $data['statuses'] = $this->project_model->get_statuses();
    $data['thumbnail_preview'] = html_purify($data['thumbnail'] ?? '');
    $data['trailer_preview'] = $this->video->get_thumbnail($data['trailer'] ?? '');

    return $data;
  }

  private function get_post_data()
  {
    $data = array(
      'id' => $_POST['id'] ?? '',
      'uri' => generate_uri($_POST['title']) ?? '',
      'thumbnail' => $_POST['thumbnail'] ?? '',
      'trailer' => $_POST['trailer'] ?? '',
      'title' => $_POST['title'] ?? '',
      'subtitle' => $_POST['subtitle'] ?? '',
      'description' => $_POST['description'] ?? '',
      'language' => $_POST['language'] ?? '',
      'date' => $_POST['date'] ?? '',
      'visibility' => $_POST['visibility'] ?? '',
      'status' => $_POST['status'] ?? '',
      'purpose' => $_POST['purpose'] ?? ''
    );

    return $data;
  }

  private function get_form($destination = '', $redirect = '', $uri = '')
  {
    $html = '';
    $data = $this->get_parser_data($uri) ?? array();
    $data['destination'] = $destination ?? '';
    $data['redirect'] = $redirect ?? '';
    $data['preview'] = html_purify(
      markdown_parse($data['description'] ?? '')
    );

    if ($destination !== '')
    {
      if ($uri !== '')
      {
        // Set all of the lists to their appropriate values
        $this->select_list_values($data);
      }

      $html = $this->parser->parse(
        'backend/projects/form.html',
        $data,
        TRUE
      );
    }

    return $html;
  }

  private function get_projects()
  {
    $projects = $this->project_model->get_projects();

    // Encode extra information into each project
    foreach ($projects as &$project)
    {
      // Allow each project to build the base URL and index page
      $project['base_url'] = base_url();
      $project['index_page'] = index_page();
    }

    return $projects;
  }

  private function get_screenshots($project)
  {
    $screenshots = $this->screenshot_model->get_screenshots($project);
    $html = '';

    // Don't add screenshots if none exist
    if (!empty($screenshots))
    {
      $data = array(
        'screenshots' => $screenshots
      );

      // Parse the data for each screenshot input
      foreach ($data['screenshots'] as &$screenshot)
      {
        $screenshot['base_url'] = base_url();
        $screenshot['input'] = $this->parser->parse(
          'backend/screenshots/input/single.html',
          $screenshot,
          TRUE
        );
      }

      $html = $this->parser->parse(
        'backend/screenshots/input/list.html',
        $data,
        TRUE
      );
    }

    return $html;
  }

  private function get_hyperlinks($project)
  {
    $hyperlinks = $this->hyperlink_model->get_project_hyperlinks($project);
    $html = '';

    // Don't add screenshots if none exist
    if (!empty($hyperlinks))
    {
      $data = array(
        'hyperlinks' => $hyperlinks
      );

      // Parse the data for each screenshot input
      foreach ($data['hyperlinks'] as &$hyperlink)
      {
        $hyperlink['base_url'] = base_url();
        $hyperlink['input'] = $this->parser->parse(
          'backend/hyperlinks/input/single.html',
          $hyperlink,
          TRUE
        );
      }

      $html = $this->parser->parse(
        'backend/hyperlinks/input/list.html',
        $data,
        TRUE
      );
    }

    return $html;
  }

  private function select_list_values(&$data)
  {
    // Visibility
    foreach($data['visibilities'] as &$visibility)
    {
      // If the current visibility value from the database equals
      // the string from this iteration of the loop
      if ($visibility['visibility'] === $data['visibility'])
      {
        // Mark this value as selected
        $visibility['selected'] = 'selected="selected"';
      }
    }

    // Status
    foreach($data['statuses'] as &$status)
    {
      // If the current visibility value from the database equals
      // the string from this iteration of the loop
      if ($status['status'] === $data['status'])
      {
        // Mark this value as selected
        $status['selected'] = 'selected="selected"';
      }
    }
  }

  private function prepare_response()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => 'No HTML data set'
    );

    return $response;
  }

  private function clean_project_titles($projects)
  {
    // Iterate over every project array given to the function
    for ($project = 0; $project < count($projects); $project++)
    {
      // Remove dangerous symbols from each title using htmlentities
      $dirty_title = $projects[$project]['title'];
      $clean_title = htmlentities(
        $dirty_title,
        ENT_QUOTES
      );
      $projects[$project]['title'] = $clean_title;
    }

    return $projects;
  }
}
