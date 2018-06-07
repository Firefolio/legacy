<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('validate_user_credentials'))
{
  function validate_user_credentials()
  {
    $CI =& get_instance();

    // Load the assets necessary for validation in case they're missing
    $CI->load->model('application_model');
    $CI->load->helper('url');

    // Determine where the form is that will force them to change their credentials
    $url = base_url() . index_page() . '/backend/security/update/credentials/form';
    // Get the current login credentials
    $current_username = strtolower($CI->application_model->get_username());
    $current_password = $CI->application_model->get_password();
    // Get the defaults to compare them with
    $default_username = strtolower($CI->application_model->get_default_username());
    $default_password = $CI->application_model->get_default_password();

    // Make sure that the username doesn't match
    if ($current_username === $default_username)
    {
      header('Location: ' . $url);
    }

    // Make sure the password isn't the default
    if ($current_password === $default_password OR // If the hash is the same for some reason
        password_verify($default_password, $current_password))
    {
      header('Location: ' . $url);
    }
  }
}
