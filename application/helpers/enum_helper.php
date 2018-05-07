<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_sql_enum_values'))
{
  function get_sql_enum_values($table, $column)
  {
    // Obtain the types from the column
    $type = $this->db->query(
      'SHOW COLUMNS FROM `' . $table .'` WHERE Field = \'' . $column .'\''
    )->row(0)->Type;
  }
}
