<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_video_id'))
{
  function get_video_id($url)
  {
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id))
    {
      $values = $id[1];
    }
    else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id))
    {
      $values = $id[1];
    }
    else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id))
    {
      $values = $id[1];
    }
    else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id))
    {
      $values = $id[1];
    }
    else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id))
    {
      $values = $id[1];
    }

    return $values;
  }
}

if (!function_exists('get_embed_url'))
{
  function get_embed_url($url)
  {
    return 'https://youtube.com/embed/' . get_video_id($url);
  }
}
