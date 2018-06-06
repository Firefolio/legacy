<?php
// Prove that we are authorised to access the index config file
define('CONFIG', TRUE);
// Gain access to the variables contained in that file
require_once 'config.php';

// Use the retrieved path to find the database config file
require_once APPPATH . 'config/database.php';

class Installer
{
  function __construct($db, $config = array())
  {
    $this->db = $db;
    $this->config = $config;
  }

  public function install()
  {
    // Build a DSN string from the values specified in the above config file
    // For this, the default database configuration is assumed
    $dsn = 'mysql:host=' .
          $this->db['default']['hostname'] .
          ';dbname=' .
          $this->db['default']['database'];

    // Attempt to create a new connection to the database using PDO
    echo 'Attempting to establish connection to database...' . '<br>';

    try
    {
      // Try to store the new connection as an object
      $pdo = new PDO(
        $dsn, // Database service name
        $this->db['default']['username'], // Username
        $this->db['default']['password'] // Password
      );
    }
    catch (PDOException $exception)
    {
      // Exit if an exception occurs
      echo 'ERROR: ' . $exception->getMessage() . '</br>';
      exit('Connection to database via PDO failed.');
    }

    echo 'Connection established!' . '<br>';

    // Define every table that will go into the database
    $table_names = array(
      'application',
      'hyperlinks',
      'profile',
      'projects',
      'screenshots'
    );

    // Check if the application has already been installed
    // based on which tables exist
    echo 'Checking for existing installation...' . '<br>';

    foreach ($table_names as $table)
    {
      $table_exists = $pdo->query('SELECT * FROM ' . $table);

      if ($table_exists)
      {
        exit('Application already installed. No direct script access allowed.');
      }
    }

    echo 'Done!' . '<br>';

    // Install all of the database tables
    echo 'Filling database with default values...' . '<br>';

    $query = $pdo->query(file_get_contents(APPPATH . '/queries/install.sql'));

    // Disconnect from the database
    $pdo = NULL;
  }
}

// TODO: Use the actual config array from the appropriate folder
$config = array();

$installer = new Installer($db, $config);
$installer->install();
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Firefolio - Installer</title>
  </head>
  <body>
    <h1>Welcome to Firefolio!</h1>
  </body>
</html>
