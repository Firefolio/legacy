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
    $this->load->helper('url');
    $this->load->library('parser');
  }

  public function index()
  {
    $data = array(
      'base_url' => base_url(),
      'title' => $this->profile_model->get_full_name(),
      'projects' => $this->project_model->get_projects()
    );

    $this->parser->parse('frontend/portfolio.html', $data);
  }

  public function project($uri)
  {
  	$data = $this->security->xss_clean(
      $this->portfolio_model->get_project($uri)
    );

    $data['base_url'] = base_url();
    $data['name'] = $this->project_model->get_full_name();
    $data['date'] = date(
      'd-m-Y',
      strtotime($data['date'])
    );

  	$this->parser->parse('frontend/project.html', $data);
  }
}
