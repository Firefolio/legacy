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
    $projects = html_purify($this->project_model->get_projects());
    $rows = array();
    $projects_per_row = 3;

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

    $data = array(
      'base_url' => base_url(),
      'index_page' => index_page(),
      'full_name' => $this->profile_model->get_full_name(),
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash(),
      'rows' => $rows,
      'languages' => $this->project_model->get_languages()
    );

    $this->parser->parse('frontend/portfolio.html', $data);
  }

  public function project($uri)
  {
  	if ($this->project_model->project_exists($uri))
    {
      // Get the data for the project from the database
      $project = $this->project_model->get_project($uri);
      $project['description'] = markdown_parse($project['description']);

      // Clean the output with HTML purifyer
      $data = html_purify($project);

      // Check to see if the trailer field has been filled in
      // before purifying it
      if (strlen($project['trailer']) > 0)
      {
        // Show the video with an appropriate view
        $data['trailer'] = $this->video->embed(
          $project['trailer'], // URL
          TRUE, // Return HTML
          '100%', // Width
          '240px' // Height
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
      $data['base_url'] = base_url();
      $data['index_page'] = index_page();
      $data['name'] = htmlentities(
        $this->profile_model->get_full_name()
      );
      $data['date'] = date(
        'd.m.Y',
        strtotime($data['date'])
      );

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
        // TODO: Turn this into a function
        // Break the data back from the search into a responsive grid
        $rows = array();
        $projects_per_row = 3;

        // Purify project data
        foreach ($projects as $project)
        {
          $project['title'] = htmlentities($project['title']);
          $project['subtitle'] = htmlentities($project['subtitle']);
          $project['language'] = htmlentities($project['language']);
        }

        // Split the projects into their own rows
        foreach (array_chunk($projects, $projects_per_row, TRUE) as $row)
        {
          array_push($rows, array('projects' => $row));
        }

        $data = array(
          'base_url' => base_url(),
          'title' => $this->profile_model->get_full_name(),
          'rows' => $rows
        );

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

  private function get_parser_data()
  {
    $data = array(
      'base_url' => base_url(),
      'index_page' => index_page()
    );
  }
}
