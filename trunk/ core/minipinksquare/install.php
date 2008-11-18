<?php
// Vor dem installieren die config.php bearbeiten
include 'config.php';

// Tabellen anlegen - BEGIN
$db = DatabaseSingleton::singleton()->getDatabase();

if(! $db->existTable(TABLE_CONTENTTYPES)){
	$fields = array(
		array('name' => 'id', 	'type' => 'INT', 	 'length' => 11, 'extra' => 'AUTO_INCREMENT'),
		array('name' => 'name', 'type' => 'VARCHAR', 'length' => 255)
	);
	$db->createTable(TABLE_CONTENTTYPES, $fields, $fields[0]['name']);
}

if(! $db->existTable(TABLE_TEMPLATES)){
	$fields = array(
		array('name' => 'id', 		'type' => 'INT', 	 'length' => 11, 'extra' => 'AUTO_INCREMENT'),
		array('name' => 'name', 	'type' => 'VARCHAR', 'length' => 255),
		array('name' => 'template', 'type' => 'LONGTEXT', 'length' => 0),
	);
	$db->createTable(TABLE_TEMPLATES, $fields, $fields[0]['name']);
}

if(! $db->existTable(TABLE_PAGES)){
	$fields = array(
		array('name' => 'id', 			'type' => 'INT', 	 'length' 	=> 11, 'extra' => 'AUTO_INCREMENT'),
		array('name' => 'name', 		'type' => 'VARCHAR', 'length' 	=> 255),
		array('name' => 'template_id', 	'type' => 'INT', 	'length' 	=> 11),
	);
	$db->createTable(TABLE_PAGES, $fields, $fields[0]['name'], array($fields[2]['name']));
}
// Tabellen anlegen - END

// Tabellen anlegen für Contenttypes - BEGIN
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
// Tabellen anlegen für Contenttypes - END
?>