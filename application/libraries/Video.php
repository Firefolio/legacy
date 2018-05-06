<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video {

  // Codeigniter instance
  protected $CI;

  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->library('parser');
  }

  public function embed($url)
  {

  }

  public function get_embed_url($url)
  {
    switch ($this->get_type($url))
    {
      case 'Youtube':
        $embed_url = 'https://youtube.com/embed/' .
                     get_video_id($url);
        break;
      default:
        break;
    }

    return $embed_url;
  }

  private function get_video_id($url)
  {
    $id = '';

    switch ($this->get_type($url))
    {
      case 'Youtube':
      // Obtain the video ID through the use of regular expressions
      // Checking against every pattern related to youtube
      if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches))
      {
        $id = $matches[1];
      }
      else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches))
      {
        $id = $matches[1];
      }
      else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches))
      {
        $id = $matches[1];
      }
      else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches))
      {
        $id = $matches[1];
      }
      else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $matches))
      {
        $id = $matches[1];
      }
        break;
    }

    return $id;
  }

  public function get_type($url)
  {
    // Obtain the video ID through the use of regular expressions
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url) OR
        preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url) OR
        preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url) OR
        preg_match('/youtu\.be\/([^\&\?\/]+)/', $url) OR
        preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url))
    {
      // The link is from Youtube
      $type = 'Youtube';
    }

    return $type;
  }
}
