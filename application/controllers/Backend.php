<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('parser');
    $this->load->helper('url');
  }

  public function dashboard()
  {
    session_start();

    if (isset($_SESSION['user']))
    {
      $data = array(
        'base_url' => base_url()
      );

      $this->parser->parse('backend/dashboard.html', $data);
    }
    else
    {
      $url = base_url() . 'login';

      header('Location: ' . $url);
      exit();
    }
  }
}
