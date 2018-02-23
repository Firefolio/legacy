<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
    $this->load->helper('url');
  }

  public function get_project($uri)
  {
	  $query = $this->db->query(
		file_get_contents(base_url() . 'sql/get_project.sql'),
		$uri
	  );

	  $project = $query->row_array();

	  return $project;
  }

  public function get_projects()
  {
    $query = $this->db->query(
      file_get_contents(base_url() . 'sql/get_projects.sql')
    );

    return $query->result_array();
  }

  public function get_languages()
  {
    // Send a query to get all values from the 'language' column
    // Note that this won't work with any values with commas in them
    $query = $this->db->query(file_get_contents('sql/get_languages.sql'));
    // Get the type of column from the first row
    $type = $query->row(0)->Type;
    // Parse those values as a regular expression
    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
    // Convert the matching values into an array
    $enum = explode("','", $matches[1]);
    $languages = array();

    // Format that array for the template parser
    foreach ($enum as $value)
    {
      array_push($languages, array('name' => $value));
    }

    return $languages;
  }

  public function insert_project(array $project)
  {
    $query = $this->db->query(file_get_contents('sql/insert_project.sql'));
  }

  public function get_full_name()
  {
    $query = $this->db->query('SELECT * FROM `profile` LIMIT 1');
    $row = $query->row_array();
    $full_name = $row['first_name'] .
      ' ' .
      $row['middle_name'] .
      ' ' .
      $row['last_name'];

    return $full_name;
  }
}
