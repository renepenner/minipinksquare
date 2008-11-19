<?php
class Template{
	
	private $id;
	private $template;
	private $name;
	private $db;
	private $placeholder = array();
	
	public function __construct($id=false){
		$this->db = DatabaseSingleton::singleton()->getDatabase();
		if($id) $this->init($id);
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getPlaceholder(){
		return $this->placeholder;
	}
	
	public function getTemplate(){
		return $this->template;
	}
	
	public function getName(){
		return $this->name;
	}
	
	private function init($id){
		$this->id = $id;
		
		$res = $this->db->getAll("SELECT * FROM ".TABLE_TEMPLATES." WHERE id = $id");
		
		$this->name 	= $res[0]['name'];
		$this->template = $res[0]['template'];
		$this->renderTemplate();
	}
	
	public function setTemplate($template){
		$this->template = $template;
	}
	
	public function setName($name){
		$this->name = $name;
	}
	
	public function store(){
		$this->id = $this->db->storeTemplate($this);
	}
	
	private function renderTemplate(){
		preg_match_all('/(?<tag><mps:(?<type>.*?) (?<attribute>.*?)\/>)/i', $this->template, $res);
		for($i=0;$i<count($res[0]);$i++){
			$type 		= $res['type'][$i];
			$attribute 	= $res['attribute'][$i];
			$tag		= $res['tag'][$i];
			preg_match_all('/(?<key>.*?)=(\'|")(?<value>.*?)(\'|")/', $attribute, $res2);
			$attribute = array();
			for($ii=0;$ii<count($res2[0]);$ii++){
				$attribute[trim($res2['key'][$ii])] = trim($res2['value'][$ii]);
			}
			$this->placeholder[] = array('tag' => $tag, 'type' => $type, 'attribute' => $attribute);
		}		
		return $this->template;
	}

}
?>