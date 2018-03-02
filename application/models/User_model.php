<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
  function __construct()
  {
    $this->load->database();
    $this->load->helper('url');
  }

  public function get_user()
  {
    $query = $this->db->get('user');
    $row = $query->row_array();

    return $row;
  }

  public function update_username($username)
  {
    $this->db->update('user', array('username' => $username));
  }

  public function update_password($password)
  {
    // Don't store the user's password in plain text!
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $this->db->update('user', array('password' => $hash));
  }
}
