<?php
class Page{
	
	private $name;
	private $template;
	private $content;
	private $db;
	private $id;
	
	public function __construct($id=false){
		$this->db = DatabaseSingleton::singleton()->getDatabase();
		if($id) $this->init($id);
	}
	
	private function init($id){
		$res = $this->db->getAll("SELECT * FROM ".TABLE_PAGES." WHERE id = $id");
		
		$this->id = $id;
		$this->name = $res[0]['name'];
		$this->template = new Template($res[0]['template_id']);
		$this->renderPage();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setName($name){
		$this->name = $name;
	}
		
	/**
	 * 
	 * @return Template
	 */
	public function getTemplate(){
		return $this->template;
	}
	
	public function setTemplate(Template $t){
		$this->template = $t;
	}
	
	public function renderPage(){
		$content = $this->template->getTemplate();
		foreach($this->template->getPlaceholder() as $placeholder){
			$sql = "SELECT value FROM contentvalues_".$placeholder['type']." WHERE page_id = ".$this->id." AND name = '".$placeholder['attribute']['name']."'";
			$replacement = $this->db->getValue($sql);
			$content = preg_replace('~'.$placeholder['tag'].'~', $replacement, $content);
		}
		$this->content = $content;
	}
	
	public function show(){
		return $this->content;
	}
	
	public function store(){
		// Seite updaten
		$this->id = $this->db->storePage($this);
	}
}
?>