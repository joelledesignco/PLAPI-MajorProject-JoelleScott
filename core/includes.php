<?php session_start();
// Create constant variable to hold path to root of project
define( 'APP_ROOT', substr(__DIR__, 0, strrpos(__DIR__, DIRECTORY_SEPARATOR)) );

require_once(APP_ROOT."/core/db.php");
require_once(APP_ROOT."/core/util.php");

// Automatically include a relevant /models class if it is instantiated, for project scalability purposes.
spl_autoload_register(function ($class) {
    // add .php file extension and lower case class name to match with corresponding filename
	$filename = strtolower($class) . '.php';

    // Check if instantiated class is in the models folder before trying to include it
	if( file_exists(APP_ROOT . '/models/' . $filename)){
		require_once APP_ROOT . '/models/' . $filename;
	}
});

require_once(APP_ROOT."/core/init.php");
