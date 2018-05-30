<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portfolio extends CI_Controller {

  private $projects_per_row = 4;

  public function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function index()
  {
    // Configure data for the template parser specific to this page
    $data = $this->get_parser_data();
    $data['rows'] = $this->get_project_rows($data['projects'], $this->projects_per_row);
    $data['project_grid'] = $this->parser->parse(
      'frontend/project/grid.html',
      $data,
      TRUE
    );

    // Get the project categories and orders from JSON files on the server
    $categories = json_decode(
      file_get_contents(
        base_url() . 'json/project/categories.json'
      )
    );
    $orders = json_decode(
      file_get_contents(
        base_url() . 'json/project/orders.json'
      )
    );
    $data['categories'] = $this->filter_columns($categories);
    $data['orders'] = $this->filter_columns($orders);

    $this->parser->parse('frontend/portfolio.html', $data);
  }

  public function project($uri)
  {
  	if ($this->project_model->project_exists($uri))
    {
      // Get the data for the project from the database
      $data = html_purify($this->get_parser_data($uri));
      // This has to be filtered in its own function to maintain
      // necessary data attributes
      $data['description'] = markdown_parse(html_purify($data['description']));
      $data['screenshots'] = $this->get_screenshots($data['id']);

      // Check to see if the trailer field has been filled in
      // before purifying it
      if (strlen($data['trailer']) > 0)
      {
        // Show the video with an appropriate view
        $data['trailer'] = $this->video->embed(
          $data['trailer'], // URL
          TRUE // Return HTML
        );
      }
      else
      {
        // Show a larger version of the thumbnail instead
        $data['trailer'] = $this->parser->parse(
          'frontend/project/thumbnail.html',
          $data,
          TRUE // Return result as a string
        );
      }

    	$this->parser->parse('frontend/project.html', $data);
    }
    else
    {
      show_404();
    }
  }

  public function search()
  {
    $response = array(
      'success' => TRUE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => 'No HTML data set'
    );

    if (isset($_POST['search']))
    {
      // Create shortcut variables for each stage of the query
      $search = $_POST['search'] ?? '';
      $like = $_POST['like'] ?? '';
      $by = $_POST['by'] ?? '';
      $order = $_POST['order'] ?? '';

      $response['success'] = TRUE;
      $response['message'] = 'Found some projects from query';

      $projects = $this->project_model->search_projects(
        $search,
        $like,
        $by,
        $order,
        FALSE // Show private projects
      );

      if (count($projects) > 0)
      {
        $data = $this->get_parser_data();
        $data['rows'] = $this->get_project_rows($projects, $this->projects_per_row);

        $response['html'] = $this->parser->parse(
          'frontend/project/grid.html',
          $data,
          TRUE
        );
      }
      else
      {
        $response['html'] = 'No projects with the given parameters were found.';
      }
    }

    $json = json_encode($response);
    echo $json;
  }

  private function load_assets()
  {
    // Models
    $this->load->model('application_model');
    $this->load->model('profile_model');
    $this->load->model('project_model');
    $this->load->model('screenshot_model');
    $this->load->model('hyperlink_model');

    // Helpers
    $this->load->helper('backup');
    $this->load->helper('date');
    $this->load->helper('security');
    $this->load->helper('html_purifier');
    $this->load->helper('markdown');
    $this->load->helper('url');

    // Libraries
    $this->load->library('parser');
    $this->load->library('video');
  }

  private function get_project_rows($projects = array(), $projects_per_row = 3)
  {
    // Figure out the width of each column in the grid
    // based on how many columns should be in each row
    $column_sizes = array(
      12 => 'one column',
      6  => 'two columns',
      4  => 'three columns',
      3  => 'four columns',
      2  => 'six columns',
      1  => 'twelve columns',
    );
    $column_size = $column_sizes[$projects_per_row] ?? '';

    // Get the project data from the database in such a way that only
    // publically visible projects are collected
    $rows = array();

    // Filter the output of each project and format it
    foreach ($projects as &$project)
    {
      $project['title'] = htmlentities($project['title']);
      $project['subtitle'] = htmlentities($project['subtitle']);
      // Filter the project language if it's been set
      $project['language'] = ($project['language'] != '') ? htmlentities(
        $project['language']
      ) : 'Unspecified';
      // Filter and format the date of the project if it's been set
      $project['date'] = ($project['date'] != '0000-00-00') ? htmlentities(
        date(
          'Y', // Show only the year of release
          strtotime($project['date'])
        )
      ) : 'TBD';

      // Include URL data
      $project['base_url'] = base_url();
      $project['index_page'] = index_page();

      // Add in the size of the column
      $project['column_size'] = $column_size;

      // WARNING: Any other data from this function will be unfiltered!
    }

    // Split the projects into their own rows on the responsive grid
    foreach (array_chunk($projects, $projects_per_row, TRUE) as $row)
    {
      array_push($rows, array('projects' => $row));
    }

    return $rows;
  }

  private function get_parser_data($uri = '')
  {
    // WARNING: the following function does not purify user output on its own.
    // Use htmlentities and html_purify to prevent XSS attacks from user data!
    $data = array();

    // Determine whether a single project, or multiple projects are needed
    if ($uri != '')
    {
      // Single project
      $data = $this->project_model->get_project($uri);

      $data['date'] = date('d.m.Y', strtotime($data['date']));
      $data['details'] = $this->get_details($data);
    }
    else
    {
      // Multiple projects
      $data['projects'] = $this->project_model->get_projects(array('visibility' => 'public'));
    }

    // Then add all of the other data we might need on top
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['csrf_name'] = $this->security->get_csrf_token_name();
    $data['csrf_hash'] = $this->security->get_csrf_hash();
    $data['languages'] = $this->project_model->get_languages();
    $data['full_name'] = htmlentities(
      $this->profile_model->get_full_name()
    );
    $data['biography'] = htmlentities(
      $this->profile_model->get_biography() ?? ''
    );
    $data['visibilities'] = $this->project_model->get_visibilities();
    $data['username'] = htmlentities($this->application_model->get_username());
    $data['login'] = $this->get_login($data);
    $data['year'] = date('Y');
    $data['hyperlinks'] = $this->get_hyperlinks();

    return $data;
  }

  private function get_details($project)
  {
    $data = array(
      'details' => array(),
      'technologies' => array(),
      'hyperlinks' => $this->hyperlink_model->get_project_hyperlinks($project['id'])
    );
    $columns = array(
      'language',
      'date',
      'status',
      'purpose'
    );
    $html = '';

    if (isset($project))
    {
      // Check each field of the project
      foreach ($project as $key => $value)
      {
        // Check its key against all of the columns that could be a detail
        foreach ($columns as $column)
        {
          // If that column is in the array of approved columns
          if ($key === $column)
          {
            // And the value of that column isn't blank
            if ($value != '')
            {
              array_push(
                $data['details'],
                array(
                  'header' => ucfirst($key),
                  'content' => html_purify($value)
                )
              );
            }
          }
        }
      }

      $html = $this->parser->parse(
        'frontend/details.html',
        $data,
        TRUE
      ) ?? '';
    }

    return $html;
  }

  private function get_hyperlinks()
  {
    // NOTE: This function refers to social media links
    $data = array(
      'hyperlinks' => $this->hyperlink_model->get_profile_hyperlinks()
    );
    $html = '';

    if (!empty($data['hyperlinks']))
    {
      foreach($data['hyperlinks'] as &$hyperlink)
      {
        $hyperlink['icon'] = html_purify($this->get_icon_path($hyperlink['url']));
      }

      $html = $this->parser->parse(
        'frontend/profile/hyperlinks.html',
         $data,
         TRUE
      );
    }

    return $html;
  }

  private function get_icon_path($url = '')
  {
    $this->config->load('social_media_icons', TRUE);
    // Parse the url sent to the function
    $parsed_url = parse_url($url);
    // This will be the default icon if the host isn't recognised
    $default_icon = base_url() . '/img/icons/open-iconic/link-intact.svg';
    // Ensure that the index we're checking doesn't use the World Wide Web
    $host = preg_replace('/^www\./', '', $parsed_url['host'] ?? '');
    // Set the path based on the host of the parsed URL
    $path = $this->config->item('social_media_icons')[$host] ?? $default_icon;

    return $path;
  }

  private function get_screenshots($project, $screenshots_per_row = 2)
  {
    $screenshots = $this->screenshot_model->get_screenshots($project);

    // Don't output the screenshot grid if it's empty
    if (!empty($screenshots))
    {
      // Put the screenshots in a responsive grid
      $data = array(
        'rows' => array()
      );

      foreach (array_chunk($screenshots, $screenshots_per_row, TRUE) as $row)
      {
        array_push($data['rows'], array('screenshots' => $row));
      }

      $html = $this->parser->parse(
        'frontend/screenshots.html',
        $data,
        TRUE
      );
    }
    else
    {
      $html = '';
    }

    return $html;
  }

  private function get_login($data)
  {
    session_start();

    $html = '';

    if (isset($_SESSION['user']))
    {
      $html = $this->parser->parse(
        'frontend/logout.html',
        $data,
        TRUE
      );
    }
    else
    {
      $html = $this->parser->parse(
        'frontend/login.html',
        $data,
        TRUE
      );
    }

    return $html;
  }

  private function filter_columns($whitelist = array())
  {
    $columns = $this->project_model->get_columns(FALSE);
    $categories = array();

    // Only return categories on the whitelist
    foreach ($columns as $column)
    {
      foreach ($whitelist as $item)
      {
        if ($column['name'] == $item)
        {
          $category = array(
            'name' => $column['name']
          );

          array_push($categories, $category);
        }
      }
    }

    return $categories;
  }
}
