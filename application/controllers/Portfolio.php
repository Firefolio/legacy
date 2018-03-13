<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends CI_Controller {
  public function __construct()
  {
    parent::__construct();

    $this->load->model('profile_model');
    $this->load->model('project_model');

    $this->load->helper('date');
    $this->load->helper('security');
    $this->load->helper('video');
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
    $this->load->helper('url');

    $this->load->library('parser');
  }

  public function index()
  {
    $projects = $this->project_model->get_projects();
    $rows = array();
    $projects_per_row = 3;

    // Purify project data
    foreach ($projects as $project)
    {
      $project['title'] = htmlentities($project['title']);
      $project['subtitle'] = htmlentities($project['subtitle']);
    }

    // Split the projects into their own rows
    foreach (array_chunk($projects, $projects_per_row, TRUE) as $row)
    {
      array_push($rows, array('projects' => $row));
    }

    $data = array(
      'base_url' => base_url(),
      'title' => $this->profile_model->get_full_name(),
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
      $project = $this->project_model->get_project($uri);
      $project['description'] = markdown_parse($project['description']);

      $data = html_purify($project);
      $data['trailer'] = html_purify(
        get_embed_url($project['trailer'])
      );
      $data['base_url'] = base_url();
      $data['name'] = htmlentities(
        $this->profile_model->get_full_name()
      );
      $data['date'] = date(
        'd-m-Y',
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
      'success' => true,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => 'Unspecified error'
    );

    if (isset($_POST['query']) && isset($_POST['language']))
    {
      $title = $_POST['query'];
      $language = $_POST['language'];

      $response['success'] = TRUE;
      $response['message'] = 'Found some projects from query';

      $projects = $this->project_model->search_projects($title);

      if (sizeof($projects) > 0)
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
        }

        // Split the projects into their own rows
        foreach (array_chunk($projects, $projects_per_row, TRUE) as $row)
        {
          array_push($rows, array('projects' => $row));
        }

        $data = array(
          'base_url' => base_url(),
          'title' => $this->profile_model->get_full_name(),
          'csrf_name' => $this->security->get_csrf_token_name(),
          'csrf_hash' => $this->security->get_csrf_hash(),
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
        if ($language === "All")
        {
          $response['html'] = 'No projects like "' .
                                 htmlentities($title) .
                                 '" were found.';
        }
        else
        {
          // Include the language in the feedback
          $response['html'] = 'No projects like "' .
                                 htmlentities($title) .
                                 '" written in ' .
                                 htmlentities($language) .
                                 ' were found.';
        }
      }
    }
    else
    {
      $response['message'] = 'No data posted';
    }

    $json = json_encode($response);
    echo $json;
  }
}
