<?php
class ContentTextfield extends Content implements iContent 
{
	private $contentname = "Textfield";
	
	public function ContentTextfield(){
		parent::__construct();
	}
	
	public function initContenttype(){
		if($this->db->hasContenttype($this->contentname)){
			echo "Contenttype existiert schon!";
		}else{
			echo "Contenttype wird angelegt";
		}
	}
}
?>