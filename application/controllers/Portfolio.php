<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends CI_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('profile_model');
    $this->load->model('project_model');
    $this->load->model('language_model');

    $this->load->helper('date');
    $this->load->helper('security');
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
    $this->load->helper('url');

    $this->load->library('parser');
    $this->load->library('video');
  }

  public function index()
  {
    var_dump($this->project_model->get_visibilities());
    $data = $this->get_parser_data();
    $data['rows'] = $this->get_project_rows();

    $this->parser->parse('frontend/portfolio.html', $data);
  }

  public function project($uri)
  {
  	if ($this->project_model->project_exists($uri))
    {
      // Get the data for the project from the database
      $data = html_purify($this->get_parser_data($uri));

      // Check to see if the trailer field has been filled in
      // before purifying it
      if (strlen($data['trailer']) > 0)
      {
        // Show the video with an appropriate view
        $data['trailer'] = $this->video->embed(
          $data['trailer'], // URL
          TRUE // Return HTML
        );
      }
      else
      {
        // Show a larger version of the thumbnail instead
        $data['trailer'] = $this->parser->parse(
          'frontend/thumbnail.html',
          $data,
          TRUE // Return result as a string
        );
      }

      $data['date'] = date('d.m.Y', strtotime($data['date']));

    	$this->parser->parse('frontend/project.html', $data);
    }
    else
    {
      show_404();
    }
  }

  public function search()
  {
    $response = array(
      'success' => TRUE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => 'No HTML data set'
    );

    if (isset($_POST['input']))
    {
      $title = $_POST['input'];

      $response['success'] = TRUE;
      $response['message'] = 'Found some projects from query';

      $projects = $this->project_model->search_projects($title);

      if (count($projects) > 0)
      {
        $data = $this->get_parser_data();
        $data['rows'] = $this->get_project_rows();

        $response['html'] = $this->parser->parse(
          'frontend/thumbnails.html',
          $data,
          TRUE
        );
      }
      else
      {
        $response['html'] = 'No projects like "' .
                             htmlentities($title) .
                             '" were found.';
      }
    }

    $json = json_encode($response);
    echo $json;
  }

  private function get_project_rows($projects_per_row = 3)
  {
    $projects = html_purify($this->project_model->get_projects());
    $rows = array();

    for ($project = 0; $project < count($projects); $project++)
    {
      // Remove styles from visible data
      $projects[$project]['title'] = htmlentities(
        $projects[$project]['title']
      );
      $projects[$project]['subtitle'] = htmlentities(
        $projects[$project]['subtitle']
      );
      $projects[$project]['language'] = htmlentities(
        $projects[$project]['language']
      );

      // Process the date to show the year only
      $projects[$project]['date'] = date(
        'Y',
        strtotime($projects[$project]['date'])
      );

      // Include URL data
      $projects[$project]['base_url'] = base_url();
      $projects[$project]['index_page'] = index_page();
    }

    // Split the projects into their own rows on the responsive grid
    foreach (array_chunk($projects, $projects_per_row, TRUE) as $row)
    {
      array_push($rows, array('projects' => $row));
    }

    return $rows;
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
    }
    else
    {
      // Multiple projects
      $data['projects'] = $this->project_model->get_projects();
    }

    // Then add all of the other data we might need on top
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();
    $data['languages'] = $this->project_model->get_languages();
    $data['full_name'] = htmlentities(
      $this->profile_model->get_full_name()
    );

    return $data;
  }
}
