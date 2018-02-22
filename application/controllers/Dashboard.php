<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('parser');
  }

  public function login()
  {
    $data = array('base_url' => base_url());
    $this->parser->parse('backend/login.html', $data);
  }
}
