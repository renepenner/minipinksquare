<?php
class ContentTextfield extends Content implements iContent 
{
	private $contentname = "Textfield";
	
	public function ContentTextfield(){
		parent::__construct();
	}
	
	public function initTable(){
		if($this->db->hasTable($this->contentname)){
			echo "Tabelle existiert schon!";
		}else{
			echo "Tabelle wird angelegt";
		}
	}
}
?>