<?php
class Contentclass{
	
	private $name;
	private $placeholder = array();
		
	public function __construct($name)
	{
		$this->name = $name;
	}
	
	public function addPlaceholder(Placeholder $p)
	{
		$this->placeholder[] = $p;
	}
	
	public function addTemplate(Template $t)
	{
	
	}
	
	public function store(){
	
	}
}
?>