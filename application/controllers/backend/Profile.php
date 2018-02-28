<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->model('profile_model');
    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('security');
  }

  public function index()
  {
    $data = array(
      'base_url' => base_url()
    );

    $this->parser->parse('backend/profile/update.html', $data);
  }
}
