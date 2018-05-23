<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_model extends CI_Model {

  private $table = 'projects';

  function __construct()
  {
    parent::__construct();

    $this->load->helper('url');
    $this->load->helper('enum');
  }

  public function get_project($uri = '')
  {
    if ($uri !== '')
    {
      // Find a project based on the URI
      $this->db->where('uri', $uri);
  	  $query = $this->db->get('projects');

  	  $project = $query->row_array();
    }
    else
    {
      $project = $this->get_blank();
    }

	  return $project;
  }

  public function get_projects($where = array(), $order = 'DESC')
  {
    // Get all of the projects in the database,
    // then sort them such that the newest goes first
    $this->db->order_by('id', $order);
    $query = $this->db->get_where('projects', $where);

    return $query->result_array();
  }

  public function get_blank()
  {
    $columns = $this->get_columns();
    $project = array();

    // Add a blank field for the name of each column
    foreach ($columns as $column)
    {
      $project[$column['name']] = '';
    }

    return $project;
  }

  public function get_languages()
  {
    $this->db->select('language');
    $this->db->distinct();
    $query = $this->db->get('projects');

    return $query->result_array();
  }

  public function get_visibilities()
  {
    $values = get_sql_enum_values('projects', 'visibility');

    // Convert that array into a format acceptable by the template parser
    $visibilities = array();

    for ($value = 0; $value < count($values); $value++)
    {
      array_push(
        $visibilities,
        array(
          'visibility' => $values[$value],
          'selected' => '' // Will be set if the value matches up
        )
      );
    }

    return $visibilities;
  }

  public function get_statuses()
  {
    $values = get_sql_enum_values('projects', 'status');

    // Convert that array into a format acceptable by the template parser
    $statuses = array();

    for ($value = 0; $value < count($values); $value++)
    {
      array_push(
        $statuses,
        array(
          'status' => $values[$value],
          'selected' => '' // Will be set if the value matches up
        )
      );
    }

    return $statuses;
  }

  public function get_columns($format = FALSE)
  {
    $fields = $this->db->field_data($this->table);
    $columns = array();

    if ($format === TRUE)
    {
      foreach ($fields as $field)
      {
        array_push(
          $columns, // Array
          array(
            'name' => ucwords(
              str_replace(
                '_', // Search
                ' ', // Replacement
                $field->name // String
              )
            )
          )
        );
      }
    }
    else
    {
      foreach ($fields as $field)
      {
        array_push($columns, array('name' => $field->name));
      }
    }

    return $columns;
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
