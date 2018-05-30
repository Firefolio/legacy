<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  public function get_profile()
  {
    $query = $this->db->get('profile');

    return $query->row_array();
  }

  public function get_first_name()
  {
    $query = $this->db->get('profile');
    $row = $query->row_array();

    return $row['first_name'];
  }

  public function get_middle_name()
  {
    $query = $this->db->get('profile');
    $row = $query->row_array();

    return $row['middle_name'];
  }

  public function get_last_name()
  {
    $query = $this->db->get('profile');
    $row = $query->row_array();

    return $row['last_name'];
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

  public function get_biography()
  {
    $query = $this->db->get('profile');
    $row = $query->row_array();

    return $row['biography'];
  }

  public function get_email()
  {
    $query = $this->db->get('profile');
    $row = $query->row_array();

    return $row['email'];
  }

  public function update_profile($profile)
  {
    $this->db->update('profile', $profile);
  }
}
