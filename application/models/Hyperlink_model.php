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

  public function get_profile_hyperlinks()
  {
    $query = $this->db->get_where(
      $this->table,
      array(
        'type' => 'profile'
      )
    );
    $result = $query->result_array();

    return $result;
  }

  public function insert($hyperlink)
  {
    $this->db->insert($this->table, $hyperlink);

    return $this->db->insert_id();
  }

  public function update($hyperlink)
  {
    $this->db->update(
      $this->table,
      $hyperlink,
      array('id' => $hyperlink->id)
    );
  }

  public function delete($id)
  {
    $this->db->delete($this->table, array('id' => $id));
  }

  public function get_row_count()
  {
    $query = $this->db->get($this->table);
    $total = $query->num_rows();

    return $total;
  }
}
