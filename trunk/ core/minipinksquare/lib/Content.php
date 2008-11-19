<?php
abstract class Content 
{
		
	protected $db;
	
	public function Content(){
		$this->db = DatabaseSingleton::singleton()->getDatabase();
		$this->initContenttype();
	}
}
?>