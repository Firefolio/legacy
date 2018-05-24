<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');

    $this->load->model('application_model');

    $this->load->library('parser');
  }

  public function index()
  {
    $data = $this->get_parser_data();
    $this->parser->parse('backend/about.html', $data);
  }

  private function get_parser_data()
  {
    $data = array();
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['application_name'] = $this->application_model->get_name();
    $data['major_version'] = $this->application_model->get_major_version();
    $data['minor_version'] = $this->application_model->get_minor_version();
    $data['patch'] = $this->application_model->get_patch();
    $data['website'] = $this->application_model->get_website();
    $data['navbar'] = $this->parser->parse('backend/navbar.html', $data, TRUE);
    $data['stylesheets'] = $this->parser->parse('backend/stylesheets.html', $data, TRUE);

    return $data;
  }
}
