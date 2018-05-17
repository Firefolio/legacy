<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Screenshot_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  public function get_screenshots($project)
  {
    if (isset($project))
    {
      $query = $this->db->get_where(
        'screenshots',
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
}
