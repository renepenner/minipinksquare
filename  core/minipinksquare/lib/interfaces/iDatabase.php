<?php
interface iDatabase
{
	
	public function query($query, $values = array(), $returnResult = false);
	
	public function getValue($query, $values = array(), $default = false);
	
	public function getAll($query, $values = array()); 
	
	public function hasContentDatabaseRelation($contenttype);

	public function createContentDatabaseRelation($contenttype, $type);
	
	public function getDriverFieldtype($key);
	
	public function createTable($name, $fields, $primarykey, $indexes = array(), $engine='');

	public function existTable($name);
}
?>