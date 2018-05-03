<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('require_authentication'))
{
  function require_authentication()
  {
    session_start();

    if (!isset($_SESSION['user']))
    {
      // Redirect the user to the login screen and exit
      header('Location: ' . base_url() . 'index.php/login');
    }
  }
}
