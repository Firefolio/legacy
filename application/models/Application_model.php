<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  public function get_name()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['name'];
  }

  public function get_major_version()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['major_version'];
  }

  public function get_minor_version()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['minor_version'];
  }

  public function get_patch()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['patch'];
  }

  public function get_default_password()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['patch'];
  }
}
