<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hyperlink_model extends CI_Model {

  private $table = 'hyperlinks';

  function __construct()
  {
    parent::__construct();
  }

  public function get_hyperlinks($project)
  {
    $query = $this->db->get_where(
      $this->table,
      array('project' => $project)
    );
  }
}
