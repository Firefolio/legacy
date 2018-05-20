<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screenshot_model extends CI_Model {

  private $table = 'screenshots';

  public function __construct()
  {
    parent::__construct();
  }

  public function get_screenshots($project)
  {
    if (isset($project))
    {
      $query = $this->db->get_where(
        $this->table,
        array('project' => $project)
      );

      $screenshots = $query->result_array();
    }
    else
    {
      $query = $this->db->get('screenshots');
      $screenshots = $query->result_array();
    }

    return $screenshots;
  }

  public function insert($screenshot = array())
  {
    $this->db->insert('screenshots', $screenshot);

    return $this->db->insert_id();
  }

  public function update($screenshot)
  {
    $this->db->update(
      $this->table,
      $screenshot,
      array('id' => $screenshot->id)
    );
  }
}
