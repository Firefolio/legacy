<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('to_ascii'))
{
  // From the 'Perfect Clean URL Generator'
  // Source: http://cubiq.org/the-perfect-php-clean-url-generator

  function to_ascii($str, $replace = array(), $delimiter = '-')
  {
    if (!empty($replace))
    {
      $str = str_replace((array)$replace, ' ', $str);
    }

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
  }
}
