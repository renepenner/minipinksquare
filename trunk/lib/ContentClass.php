<?php
class ContentClass{
	
	private $id;
	private $name;
	private $placeholder;
	private $templates;
	
	public function __construct()
	{
		$this->placeholder = new PlaceholderList();
		$this->templates = new TemplateList();
	}	
	
	public function setName($name){$this->name=$name;}
	public function getName(){return $this->name;}
	
	public function setId($id){$this->id=$id;}
	public function getId(){return $this->id;}
	
	public function addPlaceholder(Placeholder $p)
	{
		$this->placeholder[] = $p;
	}
	
	public function addTemplate(Template $t)
	{
		$this->templates->add($t);
	}
	
	public function getTemplates()
	{
		$this->templates->getList();
	}
	
	public function getPlaceholder()
	{
		
	}
	
	public function store()
	{
	
	}

	public function toArray()
	{		
		return array(
			'id'			=> $this->id,
			'name'			=> $this->name,
			'templates'		=> $this->templates->toArray(),
			'placeholder'	=> $this->placeholder->toArray()
		);		
	}
}
?>