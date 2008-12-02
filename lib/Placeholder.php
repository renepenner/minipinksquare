<?php
class Placeholder{

	private $name;
	private $contenttype;

	public function __construct($name, iContent $contenttype)
	{
		$this->name 		= $name;
		$this->contenttype	= $contenttype;		
	}
	
	public function store()
	{
	
	}
}
?>