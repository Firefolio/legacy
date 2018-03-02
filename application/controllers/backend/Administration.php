<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {
  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
    $this->load->helper('security');
    $this->load->library('parser');
  }

  public function index()
  {
    $data = array(
      'base_url' => base_url(),
      'csrf_name' => $this->security->get_csrf_token_name(),
      'csrf_hash' => $this->security->get_csrf_hash()
    );

    $this->parser->parse('backend/administration/update.html', $data);
  }

  public function update()
  {
    
  }
}
