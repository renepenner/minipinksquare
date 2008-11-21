<?php
interface iDatabase
{
	public function storeTemplate(Template $t);
	
	public function storePage(Page $p);	
	
	public function hasContentDatabaseRelation($contenttype);
	
	public function createContentDatabaseRelation($contenttype, $type);
	
}
?>