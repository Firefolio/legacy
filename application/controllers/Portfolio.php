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
    $this->load->helper('url');
    $this->load->library('parser');
  }

  public function index()
  {
    $projects = $this->project_model->get_projects();
    $rows = array();
    $projects_per_row = 3;

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

    $this->parser->parse('frontend/portfolio.html', $data);
  }

  public function project($uri)
  {
  	if (sizeof($this->project_model->get_project($uri)) > 0)
    {
      $project = $this->project_model->get_project($uri);

      $data = $this->security->xss_clean($project);
      $data['trailer'] = get_embed_url($project['trailer']);
      $data['base_url'] = base_url();
      $data['name'] = $this->profile_model->get_full_name();
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
}
