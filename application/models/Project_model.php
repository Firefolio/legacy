<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
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
    // Get all of the projects in the database,
    // then sort them such that the newest goes first
    $this->db->order_by('id', 'DESC');
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  public function get_languages()
  {
    // TODO: Use a pointer to get the name from the languages table
    $this->db->select('language');
    $this->db->distinct();
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  public function get_visibilities()
  {
    // Obtain the types from the column
    $type = $this->db->query(
      'SHOW COLUMNS FROM `projects` WHERE Field = \'visibility\''
    )->row(0)->Type;
    // Use a regular expression to convert those types to an array of matched
    // strings
    preg_match('/^enum\(\'(.*)\'\)$/', $type, $matches);
    $visibilities = explode('\',\'', $matches[1]);

    return $visibilities;
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
