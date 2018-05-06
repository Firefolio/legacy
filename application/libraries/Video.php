<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video {

  // Codeigniter instance
  protected $CI;

  public function __construct()
  {
    $this->CI =& get_instance();

    $this->CI->load->helper('html_purifier');
    $this->CI->load->library('parser');
  }

  // Embeds a video onto the page using its type
  // Optionally returning the embed code as a string
  public function embed($url, $return = FALSE, $width = '100%', $height = 'auto')
  {
    $data = array(
      'width' => $width,
      'height' => $height
    );
    $html = '';

    switch ($this->get_type($url))
    {
      case 'youtube':
        $data['source'] = 'https://youtube.com/embed/' . $this->get_video_id($url);
        $html = $this->CI->parser->parse('video/youtube.html', $data, $return);
        break;
      default:
        break;
    }

    if ($return)
    {
      return $html;
    }
  }

  // Returns a video's ID based on it's type
  private function get_video_id($url)
  {
    $id = '';
    $expressions = array(
      'youtube' => array(
        '/youtube\.com\/watch\?v=([^\&\?\/]+)/', // Regular video URL (GET)
        '/youtube\.com\/embed\/([^\&\?\/]+)/', // Embed URl
        '/youtube\.com\/v\/([^\&\?\/]+)/', // Modern URL
        '/youtu\.be\/([^\&\?\/]+)/', // Shortened Youtube link
        '/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/' // Playlist URL
      )
    );

    switch ($this->get_type($url))
    {
      case 'youtube':
        // Check against every pattern that would suggest this is a youtube video
        for ($pattern = 0; $pattern < count($expressions['youtube']); $pattern++) {
          if (preg_match($expressions['youtube'][$pattern], $url, $matches))
          {
            $id = $matches[1];
          }
        }
        break;
      case 'vimeo':
        // We have to talk to Vimeos oEmbed API to find the ID for embedding
        
        break;
    }

    return $id;
  }

  // Returns the type of video based on its URL
  // The type string will always be in lower case
  // TODO: Find out how to return an enum value instead
  private function get_type($url)
  {
    $parsed_url = parse_url($url);

    if ($parsed_url['host'] === 'www.youtube.com' OR
        $parsed_url['host'] === 'youtube.com' OR
        $parsed_url['host'] === 'youtu.be')
    {
      $type = 'youtube';
    }
    elseif ($parsed_url['host'] === 'www.vimeo.com' OR
            $parsed_url['host'] === 'vimeo.com')
    {
      $type = 'vimeo';
    }
    else
    {
      // Assume self-hosted HTML5
      $type = 'html5';
    }

    return $type;
  }
}
