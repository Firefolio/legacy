<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  public function get_project($uri)
  {
	  $query = $this->db->query(
		'SELECT * FROM `projects` WHERE `uri` = ?',
		$uri
	  );
	  
	  $project = $query->row_array();
	  
	  return $project;
  }

  public function get_projects()
  {
    $query = $this->db->query(
		'SELECT * FROM `projects` ORDER BY `initiative` DESC'
	);

    return $query->result_array();
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
