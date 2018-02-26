<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {
  function __construct()
  {
    parent::__construct();
  }

  public function get_full_name()
  {
    $this->db->select('first_name, last_name, middle_name');
    $query = $this->db->get('profile');
    $row = $query->row_array();
    $full_name = $row['first_name'] .
                 ' ' .
                 $row['middle_name'] .
                 ' ' .
                 $row['last_name'];

    return $full_name;
  }
}
