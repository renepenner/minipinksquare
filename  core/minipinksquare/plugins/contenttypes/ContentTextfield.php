<?php
class ContentTextfield extends Content implements iContent 
{
	private $contentname = "Textfield";
	
	public function ContentTextfield(){
		parent::__construct();
	}
	
	public function initContenttype(){
		if($this->db->hasContentDatabaseRelation($this->contentname)){
			echo "Contenttype existiert schon!";
		}else{
			$this->db->createContentDatabaseRelation($this->contentname);
			echo "Contenttype wird angelegt";
		}
	}
}
?>