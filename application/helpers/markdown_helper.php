<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('markdown_parse'))
{
  function markdown_parse($input)
  {
    require_once APPPATH . 'third_party/parsedown/Parsedown.php';

    $parsedown = new Parsedown;

    return $parsedown->parse($input);
  }
}
