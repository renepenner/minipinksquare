<?php
// Vor dem installieren die config.php bearbeiten
include 'config.php';

// Tabellen anlegen
$db = DatabaseSingleton::singleton()->getDatabase();

if(! $db->existTable(TABLE_CONTENTTYPES)){
	$fields = array(
		array('name' => 'id', 	'type' => 'INT', 	 'length' => 11, 'extra' => 'AUTO_INCREMENT'),
		array('name' => 'name', 'type' => 'VARCHAR', 'length' => 255)
	);
	$db->createTable(TABLE_CONTENTTYPES, $fields, $fields[0]['name']);
}

if ($handle = opendir(CONTENTTYPES_LIB)) {
    while (false !== ($file = readdir($handle))) 
    {
        if(preg_match('/^(.*)\.php$/i', $file, $filepath)){
        	if(class_exists($filepath[1]))
        		new $filepath[1];
        }
    }
    closedir($handle);
}
?>