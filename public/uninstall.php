<?php
// TODO: Remove this file from public view
// WARNING: This file is dangerous as it allows people to delete all data!
define('CONFIG', TRUE);

require_once 'config.php';
require_once APPPATH . 'config/database.php';

class Uninstaller
{
  // Defines every table required by the database
  private $table_names = array(
    'application',
    'hyperlinks',
    'profile',
    'projects',
    'screenshots'
  );

  function __construct($db = array('default' => array()))
  {
    $this->db = $db;
  }

  public function uninstall()
  {
    $dsn = $this->get_dsn();
    $pdo = $this->get_pdo();

    $statement = $pdo->prepare('DROP TABLE application');
    $statement->execute();

    echo 'The application has been uninstalled.';
  }

  private function installed($pdo)
  {
    foreach ($this->table_names as $table)
    {
      // This query will only succeed if the table exists
      $table_exists = $pdo->query('SELECT * FROM ' . $table);

      if ($table_exists)
      {
        // The application is installed
        return TRUE;
      }
    }

    // Assume that the program is not installed
    return FALSE;
  }

  private function get_pdo($dsn = 'mysql:host=localhost;dbname=test')
  {
    try
    {
      // Try to store the new connection as an object
      $pdo = new PDO(
        $dsn, // Database service name
        $this->db['default']['username'], // Username
        $this->db['default']['password'] // Password
      );

      return $pdo;
    }
    catch (PDOException $exception)
    {
      // Exit if an exception occurs
      echo 'ERROR: ' . $exception->getMessage() . '</br>';
      exit('Connection to database via PDO failed.');
    }
  }

  private function get_dsn()
  {
    // Build a DSN string from the values specified in the above config file
    // For this, the default database configuration is assumed
    $dsn = 'mysql:host=' .
          $this->db['default']['hostname'] .
          ';dbname=' .
          $this->db['default']['database'];

    return $dsn;
  }
}

$uninstaller = new Uninstaller($db);
$uninstaller->uninstall();
