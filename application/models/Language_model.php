<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Used for managing the list of programming languages
 */
class Language_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }

  function get_languages()
  {
    $query = $this->db->get('languages')

    return $query->result_array();
  }

  function get_distinct_languages()
  {
    $query = $this->db->get('languages')

    return $query->result_array();
  }
}
