<?php
abstract class Content 
{
	protected $db;
	
	public function Content(){
		$db_singleton = DatabaseSingleton::singleton();
		$this->db = $db_singleton->getDatabase();
		$this->initTable();
	}
}
?>