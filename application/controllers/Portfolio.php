<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends CI_Controller {
  public function index()
  {
    $this->load->helper('url');
    $this->load->library('parser');

    $data = array(
      'base_url' => base_url(),
      'title' => 'Portfolio',
      'projects' => array(
        array(
          'title' => 'Hello, World!',
          'subtitle' => 'Welcome to Firefolio'
        ),
        array(
          'title' => 'Hello, World!',
          'subtitle' => 'Welcome to Firefolio'
        )
      )
    );

    $this->parser->parse('portfolio.html', $data);
  }
}
