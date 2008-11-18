<?php
class Template{
	
	private $template;
	private $name;
	private $db;
	
	
	public function __construct($id=false){
		$this->db = DatabaseSingleton::singleton()->getDatabase();
		if($id) $this->init($id);
	}
	
	private function init($id){
		$res = $this->db->getAll("SELECT * FROM ".TABLE_TEMPLATES." WHERE id = $id");
		
		$this->name 	= $res[0]['name'];
		$this->template = $res[0]['template'];
	}
	
	public function renderTemplate(){
		return $this->template;
	}

}
?>