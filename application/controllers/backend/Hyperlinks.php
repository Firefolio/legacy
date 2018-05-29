<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hyperlinks extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load_assets();
  }

  public function insert($type = 'project')
  {
    $response = $this->prepare_response();
    $data = $this->get_parser_data();

    switch ($type)
    {
      case 'project':
        if (isset($_POST['project']))
        {
          $project = $_POST['project'];
          $hyperlink = array(
            'type' => 'project',
            'project' => $project
          );

          $data['id'] = $this->hyperlink_model->insert($hyperlink);
          $data['header'] = '';
          $data['url'] = '';

          $response['success'] = TRUE;
          $response['message'] = 'Inserted a hyperlink into project ' . $project;
          $response['html'] = $this->parser->parse(
            'backend/hyperlinks/input/single.html',
            $data,
            TRUE
          );
        }
        else
        {
          $response['message'] = 'No post data received';
        }
        break;
      case 'profile':
        $hyperlink = array(
          'type' => 'profile'
        );

        $data['id'] = $this->hyperlink_model->insert($hyperlink);
        $data['header'] = '';
        $data['url'] = '';

        $response['success'] = TRUE;
        $response['message'] = 'Inserted a hyperlink onto the profile';
        $response['html'] = $this->parser->parse(
          'backend/hyperlinks/input/single.html',
          $data,
          TRUE
        );
        break;
      default:
        show_404();
        break;
    }

    $json = json_encode($response);
    echo $json;
  }

  public function update()
  {
    $response = $this->prepare_response();

    if (isset($_POST['hyperlinks']))
    {
      $hyperlinks = json_decode($_POST['hyperlinks']);

      foreach ($hyperlinks as $hyperlink)
      {
        $this->hyperlink_model->update($hyperlink);
      }

      $response['success'] = TRUE;
      $response['message'] = 'Updated hyperlinks';
    }

    $json = json_encode($response);
    echo $json;
  }

  public function delete()
  {
    $response = $this->prepare_response();

    if (isset($_POST['id']))
    {
      $id = $_POST['id'];

      $this->hyperlink_model->delete($id);

      $response['success'] = TRUE;
      $response['message'] = 'Deleted hyperlink ' . $id;
    }

    $json = json_encode($response);
    echo $json;
  }

  private function load_assets()
  {
    // Helpers
    $this->load->helper('url');
    $this->load->helper('security');
    // Models
    $this->load->model('hyperlink_model');
    // Libraries
    $this->load->library('parser');
  }

  private function get_parser_data()
  {
    $data = array();
    $data['base_url'] = base_url();
    $data['index_page'] = index_page();
    $data['navbar'] = $this->parser->parse('backend/navbar.html', $data, TRUE);
    $data['stylesheets'] = $this->parser->parse('backend/stylesheets.html', $data, TRUE);

    return $data;
  }

  private function prepare_response()
  {
    $response = array(
      'success' => FALSE,
      'message' => 'No error message specified',
      'hash' => $this->security->get_csrf_hash(),
      'html' => ''
    );

    return $response;
  }
}
