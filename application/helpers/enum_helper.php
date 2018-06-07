<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_sql_enum_values'))
{
  // WARNING: Don't let the user input values into this function!
  // It's not been escaped properly!
  // Try to only use this for outputting information to the user only
  function get_sql_enum_values($table, $column)
  {
    if (isset($table) && isset($column))
    {
      // Get a reference to Codeigniter
      $CI =& get_instance();
      // Obtain the types from the column
      $type = $CI->db->query(
        'SHOW COLUMNS FROM `' . $table .'` WHERE Field = \'' . $column .'\''
      )->row(0)->Type;
      // Use a regular expression to convert those types to an array
      preg_match('/^enum\(\'(.*)\'\)$/', $type, $matches);
      $values = explode('\',\'', $matches[1]);

      return $values;
    }
  }
}
