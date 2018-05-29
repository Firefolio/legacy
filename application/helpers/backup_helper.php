<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('backup_database'))
{
  function backup_database()
  {
    // Get a reference to the CodeIgniter framework
    $CI =& get_instance();
    // Load all of the needed models;
    $CI->load->model('application_model');
    $CI->load->model('profile_model');
    $CI->load->model('project_model');
    $CI->load->model('screenshot_model');
    $CI->load->model('hyperlink_model');
    // Encode all data in the database as an associative array
    $data = array(
      'application' => $CI->application_model->get(),
      'profile' => $CI->profile_model->get_profile(),
      'projects' => $CI->project_model->get_projects(),
      'hyperlinks' => $CI->hyperlink_model->get_hyperlinks()
    );
    $backup_folder = APPPATH . '/backups/';
    $max_backups = 5;
    // Obtain an array of all the files in the backup directory
    // except the entries used to indicate the previous directories
    // in descending order
    $files = array_diff(scandir($backup_folder, TRUE), array('.', '..'));
    // Create a file name based on the current date and time
    // This will be useful for checking future backups
    $file_name = $CI->application_model->get_name() .
                '_backup_' .
                date('Y.m.d_h.i.sa') .
                '.json';

    $json = json_encode($data, JSON_PRETTY_PRINT);

    if (count($files) + 1 > $max_backups)
    {
      // Destroy the oldest file first
      unlink($backup_folder . $files[count($files) - 1]);
      $file = fopen($backup_folder . $file_name, 'w');
      fwrite($file, $json);
      fclose($file);
    }
    else
    {
      $file = fopen($backup_folder . $file_name, 'w');
      fwrite($file, $json);
      fclose($file);
    }

    return $json;
  }
}
