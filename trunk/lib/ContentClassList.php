<?php
class ContentClassList{
	
	private $contentclasses = array();
	
	public function add(ContentClass $c){
		$this->contentclasses[] = $c;
	}
	
	public function getList(){
		return $this->contentclasses;
	}
	
	public function toArray(){
		$res = array();
		foreach($this->contentclasses as $c){
			$res[] = $c->toArray();
		}
		return $res;
	}
}
?>