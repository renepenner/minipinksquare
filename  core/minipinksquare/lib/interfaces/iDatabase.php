<?php
interface iDatabase
{
		
	public function hasContentDatabaseRelation($contenttype);

	public function createContentDatabaseRelation($contenttype, $type);
	
	public function getDriverFieldtype($key);
	
	public function createTable($name, $fields, $primarykey, $indexes = array(), $engine='');

	public function existTable($name);
}
?>