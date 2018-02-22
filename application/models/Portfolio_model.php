<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }

  public function get_projects()
  {
    $query = $this->db->get('projects');

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
