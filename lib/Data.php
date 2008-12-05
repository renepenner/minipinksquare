<?php
class Data{

	private $db;
	private $logger;
	
	public function __construct()
	{
		$this->db 		= DatabaseSingleton::singleton()->getDatabase();
		$this->logger 	= LoggerFactory::factory(LOG_TYPE);
	}
	
	public function getContentClass($id){
		return $this->db->getContentClass($id);
	}
	public function getAllContentClass(){
		return $this->db->getAllContentClass();	
	}
	public function addContentClass($name){
		return $this->db->addContentClass($name);
	}
	public function delContentClass($id){
		return $this->db->delContentClass($id);		
	}
	public function editContentClass($id, $name){
		
	}
}
?>