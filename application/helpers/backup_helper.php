<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('backup_database'))
{
  function backup_database()
  {
    // Encode all data in the database as an associative array
    $data = array(
      'application' => $this->application_model->get()
    );
    $backup_folder = APPPATH . '/backups';
    // Obtain an array of all the files in the backup directory
    // except the entries used to indicate the previous directories
    $files = array_diff(scandir($backup_folder), array('.', '..'));
    // Create a file name based on the current date and time
    // This will be useful for checking future backups

    var_dump($files);
    $json = json_encode($data, JSON_PRETTY_PRINT);
    echo $json;

    return $json;
  }
}
