<?
class MySQL implements iDatabase, iDatatypes 
{
	public $helper;
	
	public function __construct(){
		$this->helper = new MySQLHelper(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}
	
	public function hasContentDatabaseRelation($contenttype)
	{
		$contenttype = strtolower($contenttype);
		return $this->helper->existTable(TABLE_CONTENTVALUES_PREFIX.$contenttype) && $this->helper->hasValue(TABLE_CONTENTTYPES, 'name', $contenttype);
	}
	
	public function createContentDatabaseRelation($contenttype, $type)
	{
		$contenttype = strtolower($contenttype);
		if(!$this->helper->hasValue(TABLE_CONTENTTYPES, 'name', $contenttype))
			$this->helper->insert(TABLE_CONTENTTYPES, array('name' => $contenttype));

		// Anlegen einer Value Tabelle
		if(!$this->helper->existTable(TABLE_CONTENTVALUES_PREFIX.$contenttype)){
			$fields = array(
				array('name' => 'id', 				'type' => 'INT', 		'length' =>	11, 	'extra' => 'AUTO_INCREMENT'),
				array('name' => 'contenttype_id', 	'type' => 'INT', 		'length' =>	11),
				array('name' => 'page_id',	 		'type' => 'INT', 		'length' =>	11),
				array('name' => 'name',				'type' => 'VARCHAR', 	'length' =>	255),
				$this->getDriverFieldtype($type)
			);
			$this->helper->createTable(TABLE_CONTENTVALUES_PREFIX.$contenttype, $fields, $fields[0]['name'], array($fields[1]['name'], $fields[2]['name']));
		}
				
	}
	
	private function getDriverFieldtype($type){
		switch ($type){
			case MySQL::TEXTFIELD:
				return array('name' => "value", 'type' => 'VARCHAR', 'length' => "255");
				break;
			case MySQL::TEXT:
				return array('name' => "value", 'type' => 'LONGTEXT', 'length' => "");
				break;
			case MySQL::BINARY:
				return array('name' => "value", 'type' => '', 'length' => "");
				break;			
		}
	}
	
	public function storeTemplate(Template $t){
		// Bestehendes Template wurde bearbeitet
		if($t->getId()){
			$data = array('name' => $t->getName(), 'template' => $t->getTemplate()); 
			$this->helper->update(TABLE_TEMPLATES, "id=".$t->getId(), $data);
			return $t->getId();
		}
		// neues Template wird angelegt
		else{
			$data = array('name' => $t->getName(), 'template' => $t->getTemplate()); 
			return $this->helper->insert(TABLE_TEMPLATES, $data);
		}
	}
	
	public function storePage(Page $p){
	// Bestehende Seite wurde bearbeitet
		if($p->getId()){
			$data = array('name' => $p->getName(), 'template_id' => $p->getTemplate()->getId()); 
			$this->helper->update(TABLE_PAGES, "id=".$p->getId(), $data);
			return $p->getId();
		}
		// neue Seite wird angelegt
		else{
			$data = array('name' => $p->getName(), 'template_id' => $p->getTemplate()->getId() ); 
			return $this->helper->insert(TABLE_PAGES, $data);
		}
	}


	/**
	 * returns a ContentClass object
	 *
	 * @param int $id
	 * @return ContentClass
	 */
	public function getContentClass($id){
		$row = $this->helper->getRow("SELECT * FROM ".TABLE_CONTENTCLASS." WHERE id = $id");
		if(!$row) throw new Exception('Datensatz mit dieser ID nicht gefunden');
		$c = new ContentClass();
		$c->setId($row['id']);
		$c->setName($row['name']);
		return $c;
	}

	/**
	 * returns a ContentClassList object
	 *
	 * @return ContentClassList
	 */
	public function getAllContentClass(){
		$cl = new ContentClassList();
		$res = $this->helper->getAll("SELECT * FROM ".TABLE_CONTENTCLASS);
		foreach($res as $row){
			$c = new ContentClass();
			$c->setId($row['id']);
			$c->setName($row['name']);
			$cl->add($c);
		}
		return $cl;
	}

	public function addContentClass($name){		
		try{
			$res = array('success' => true, 'id' => $this->helper->insert(TABLE_CONTENTCLASS, array('name' => $name)));
			return $res;
		}
		catch (Exception $e){
			return array('success' => false);
		}
	}
}

?>
