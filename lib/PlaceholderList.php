<?php
class PlaceholderList{
	
	private $placeholders = array();
	
	public function add(Placeholder $p){
		$this->placeholders[] = $p;
	}
	
	public function getList(){
		return $this->placeholders;
	}
	
	public function toArray(){
		$res = array();
		foreach($this->placeholders as $p){
			$res[] = $p->toArray();
		}
		return $res;		
	}
}
?>