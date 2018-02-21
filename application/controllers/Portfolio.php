<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends CI_Controller {
  public function index()
  {
    $this->load->helper('url');
    $data = array(
      'base_url' => base_url()
    );
    $this->load->library('parser');
    $this->parser->parse('portfolio.html', $data);
  }
}
