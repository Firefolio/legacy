<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends CI_Controller {
  public function __construct()
  {
    parent::__construct();

    $this->load->model('portfolio_model');
    $this->load->helper('url');
    $this->load->library('parser');
  }

  public function index()
  {
    $data = array(
      'base_url' => base_url(),
      'title' => $this->portfolio_model->get_full_name(),
      'projects' => $this->portfolio_model->get_projects()
    );

    $this->parser->parse('portfolio.html', $data);
  }
}
