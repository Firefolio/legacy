<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {
  function __construct()
  {
    parent::__construct();
  }

  public function get_full_name()
  {
    $query = $this->db->query(file_get_contents('sql/get_profile.sql'));
    $row = $query->row_array();
    $full_name = $row['first_name'] .
      ' ' .
      $row['middle_name'] .
      ' ' .
      $row['last_name'];

    return $full_name;
  }
}
