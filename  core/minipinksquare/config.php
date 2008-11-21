<?php
session_start();

define('DB_TYPE', 'MySQL');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'minipinksquare');


// TABLES
define('TABLE_CONTENTTYPES', 		'contenttypes');
define('TABLE_TEMPLATES', 			'templates');
define('TABLE_PAGES', 				'pages');
define('TABLE_CONTENTVALUES_PREFIX','contentvalues_');


// PATH
define('PATH_LIB',      	dirname(__FILE__).'/lib/');
define('INTERFACE_LIB',     dirname(__FILE__).'/lib/interfaces');
define('CONTENTTYPES_LIB', 	dirname(__FILE__).'/plugins/contenttypes/');

set_include_path(get_include_path() . PATH_SEPARATOR . PATH_LIB . PATH_SEPARATOR . CONTENTTYPES_LIB . PATH_SEPARATOR . INTERFACE_LIB); 
function __autoload($class_name) {
    require_once $class_name . '.php';
}
?>