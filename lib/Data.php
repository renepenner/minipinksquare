<?php
class Data{

	private $db;
	private $logger;
	
	public function __construct()
	{
		$this->db 		= DatabaseSingleton::singleton()->getDatabase();
		$this->logger 	= LoggerFactory::factory(LOG_TYPE);
	}
	
	/**
	 * Gibt eine ContentClass zurück
	 *
	 * @param int $id
	 * @return ContentClass
	 */
	public function getContentClass($id)
	{
		return $this->db->getContentClass($id);
	}

	public function getAllContentClass()
	{
		return $this->db->getAllContentClass();	
	}

	public function addContentClass($name){
		return $this->db->addContentClass($name);
	}
}
?>