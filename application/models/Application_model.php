<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  public function get()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row;
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

  public function get_website()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['website'];
  }

  public function get_credentials()
  {
    $credentials = array(
      'username' => $this->get_username(),
      'password' => $this->get_password(),
      'default_password' => $this->get_default_password()
    );

    return $credentials;
  }

  public function get_username()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['username'];
  }

  public function get_password()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['password'];
  }

  public function get_default_username()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['default_password'];
  }

  public function get_default_password()
  {
    $query = $this->db->get('application');
    $row = $query->row_array();

    return $row['default_password'];
  }

  public function update_username($username)
  {
    $this->db->update('application', array('username' => $username));
  }

  public function update_password($password)
  {
    $this->db->update('application', array('password' => $password));
  }
}
