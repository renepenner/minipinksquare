<?php
class TemplateList{
	
	private $templates = array();
	
	public function add(Template $t){
		$this->templates[] = $t;
	}
	
	public function getList(){
		return $this->templates;
	}
	
	public function toArray(){
		$res = array();
		foreach($this->templates as $t){
			$res[] = $t->toArray();
		}
		return $res;
	}
}
?>