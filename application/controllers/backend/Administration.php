<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->model('user_model');
    $this->load->helper('url');
    $this->load->helper('security');
    $this->load->library('parser');
  }

  public function index()
  {
    $data = $this->user_model->get_user();
    $data['base_url'] = base_url();

    $this->parser->parse('backend/administration/update.html', $data);
  }

  public function update_username()
  {

  }

  public function update_password()
  {
    
  }
}
