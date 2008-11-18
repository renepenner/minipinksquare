<?php
interface iDatabase
{
		
	public function hasContentDatabaseRelation($contenttype);

	public function createContentDatabaseRelation($contenttype, $type);
	
	public function getDriverFieldtype($key);
}
?>