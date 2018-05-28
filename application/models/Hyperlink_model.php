<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hyperlink_model extends CI_Model {

  private $table = 'hyperlinks';

  function __construct()
  {
    parent::__construct();
  }

  public function get_hyperlinks()
  {
    $query = $this->db->get($this->table);
    $result = $query->result_array();

    return $result;
  }

  public function get_project_hyperlinks($project)
  {
    $query = $this->db->get_where(
      $this->table,
      array(
        'type' => 'project',
        'project' => $project
      )
    );
    $result = $query->result_array();

    return $result;
  }
}
