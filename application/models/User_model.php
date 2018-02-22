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
    $query = $this->db->query(
      file_get_contents(base_url() . 'sql/get_user.sql')
    );
    $row = $query->row();

    return $row;
  }
}
