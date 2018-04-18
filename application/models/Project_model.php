<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {
  function __construct()
  {
    $this->load->database();
    $this->load->helper('url');
  }

  public function get_project($uri)
  {
    // Find a project based on the URI
    $this->db->where('uri', $uri);
	  $query = $this->db->get('projects');

	  $project = $query->row_array();

	  return $project;
  }

  public function get_projects()
  {
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  public function insert_project($project)
  {
    $this->db->insert('projects', $project);
  }

  public function update_project($project)
  {
    $this->db->update(
      'projects',
      $project,
      array('id' => $project['id'])
    );
  }

  public function delete_project($uri)
  {
    $this->db->delete('projects', array('uri' => $uri));
  }

  public function search_projects($title, $language = 'All')
  {
    if ($language === 'All')
    {
      // Don't filter by language
      $this->db->like('title', $title);
      $query = $this->db->get('projects');
    }
    else
    {
      $this->db->like('title', $title);
      $this->db->where('language', $language);
      $query = $this->db->get('projects');
    }

    return $query->result_array();
  }

  public function project_exists($uri)
  {
    $query = $this->db->get_where('projects', array('uri' => $uri));

    return $query->num_rows() > 0;
  }
}
