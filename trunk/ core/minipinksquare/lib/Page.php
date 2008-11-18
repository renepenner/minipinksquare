<?php
class Page{
	
	private $name;
	private $template;
	private $content;
	private $db;	
	
	public function __construct($id=false){
		$this->db = DatabaseSingleton::singleton()->getDatabase();
		if($id) $this->init($id);
	}
	
	private function init($id){
		$res = $this->db->getAll("SELECT * FROM ".TABLE_PAGES." WHERE id = $id");
		
		$this->name = $res[0]['name'];
		$this->template = new Template($res[0]['template_id']);
	}
	
	public function show(){
		echo $this->template->renderTemplate();
	}
}
?>