<?php
class ContentTextfield extends Content implements iContent, iDatatypes 
{
	private $contentname = "Textfield";
	
	public function ContentTextfield(){
		parent::__construct();
	}
	
	public function initContenttype(){
		if($this->db->hasContentDatabaseRelation($this->contentname)){
			echo "Contenttype existiert schon!";
		}else{
			$this->db->createContentDatabaseRelation($this->contentname, iDatatypes::TEXTFIELD);
			echo "Contenttype wird angelegt";
		}
	}
}
?>