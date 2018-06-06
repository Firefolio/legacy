<?php
// Prove that we are authorised to access the index config file
define('CONFIG', TRUE);
// Gain access to the variables contained in that file
require_once 'config.php';

// Use the retrieved path to find the CodeIgniter config files
require_once APPPATH . 'config/config.php';
require_once APPPATH . 'config/database.php';

class Installer
{
  // Defines every table required by the database
  private $table_names = array(
    'application',
    'hyperlinks',
    'profile',
    'projects',
    'screenshots'
  );
  // The version number of this installer
  private $major_version = 0;
  private $minor_version = 2;
  private $patch = 0;

  function __construct($db = array('default' => array()), $config = array())
  {
    $this->db = $db;
    $this->config = $config;
  }

  public function install()
  {
    echo 'Firefolio Installer v' .
         $this->major_version . '.' .
         $this->minor_version . '.' .
         $this->patch . '<br>';

    $this->verify_base_url();

    echo 'Building DSN from the appropriate configuration file...' . '<br>';

    $dsn = $this->get_dsn();

    echo 'Connecting to database...' . '<br>';

    $pdo = $this->get_pdo($dsn);

    echo 'Verifying that the application isn\'t already installed...' . '<br>';

    if ($this->installed($pdo))
    {
      exit('Application already installed. No direct script access allowed.');
    }

    echo 'No valid installation found.' . '<br>';
    echo 'Inserting default values into database...' . '<br>';

    $query = $pdo->query(file_get_contents(APPPATH . '/queries/install.sql'));

    echo 'Disconnecting from database...' . '<br>';

    // Disconnect from the database
    $pdo = NULL;

    echo 'Installation complete!' . '<br>';
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

  private function verify_base_url()
  {
    // Has the base URL been set by the user?
    if (!(strlen($this->config['base_url']) > 0))
    {
      exit('Base URL cannot be blank. Have you checked your configuration?');
    }

    // Check that value is a valid URL using the built-in function
    // NOTE: Inverting the expression didn't work for some reason...
    if (filter_var($this->config['base_url'], FILTER_VALIDATE_URL) === FALSE)
    {
      exit('Base URL is invalid. Does it connect to a web page?');
    }

    // Convert the Base URL into a parsed version
    $parsed_url = parse_url($this->config['base_url']);

    if (!empty($parsed_url))
    {
      // Check it's protocol
      if ($parsed_url['scheme'] !== 'https')
      {
        // Show a warning, but don't stop the script
        echo 'WARNING: Base URL uses an insecure or unrecognised protocol!' . '<br>';
        echo 'Use HTTPS combined with a valid security certificate' . ' ';
        echo 'to keep your site safe.' . '<br>';
      }
    }
  }
}

// Create a new instance of the installer and install it
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
