<?php
interface iDatabase
{
	public function storeTemplate(Template $t);
	
	public function storePage(Page $p);	
	
	public function hasContentDatabaseRelation($contenttype);
	
	public function createContentDatabaseRelation($contenttype, $type);
	
	// ContentClass
	public function getContentClass($id);
	public function getAllContentClass();
	public function addContentClass($name);
	public function updateContentClass(ContentClass $instance);
	public function delContentClass($id);
	
}
?>