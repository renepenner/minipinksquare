<?php
class ReturnValue{
	
	private $return;
	
	public function __construct($return){
		$this->return = $return;
	}
	
	public function toArray(){
		return array('error' => $this->return);
	}
}
?>