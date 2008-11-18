<?
class MySQL implements iDatabase, iDatatypes 
{
	var $db;
	var $lastquery;
							
	function __construct()
	{
		$db		= mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Connection failed: '.mysql_error());
		$result	= mysql_select_db(DB_NAME, $db) or die('Database error: '.mysql_error());

		mysql_set_charset("utf8",$db);

		$this->db = $db;
	}

	
	function query($query, $values = array(), $returnResult = false) 
	{
		foreach ($values as $value)
		{
			$query = preg_replace('/\?/', $this->quoteSmart($value), $query, 1);
		}
		
		$this->lastquery = $query;

		$result = mysql_query(trim($query), $this->db);
		
		if (!$result)
		{
			$error = '<b>Error in SQL-Statement:</b> <pre>'.$query.'</pre><br><b>Message:</b> <pre>'.mysql_error().'</pre>';
			trigger_error($error, E_USER_WARNING);
			die();
		}

		return $returnResult ? $result : true;
	}


	function insert($table, $data) 
	{
		foreach ($data as $key => $value)
		{
			$data[$key] = $this->quoteSmart($value);
		}
		
		$this->query('INSERT INTO '.$table.' (`'.implode('`, `', array_keys($data)).'`) VALUES ('.implode(', ', array_values($data)).')');
		return mysql_insert_id($this->db);
	}


	function update($table, $where, $data) 
	{
		foreach ($data as $key => $value)
		{
			$data[$key] = '`'.$key.'`='.$this->quoteSmart($value);
		}

		$this->query('UPDATE '.$table.' SET '.implode(', ', $data).' WHERE '.$where);
		return mysql_affected_rows($this->db);
	}


	function delete($table, $where) 
	{
		$this->query('DELETE FROM '.$table.' WHERE '.$where);
		return mysql_affected_rows($this->db);
	}


	function getAll($query, $values = array()) 
	{
		$result = $this->query($query, $values, true);
		$data	= array();
		
		while ($row = mysql_fetch_assoc($result))
		{
			$data[] = $row;
		}

		mysql_free_result($result);
		return $data;
	}


	function getRow($query, $values = array()) 
	{
		$result	= $this->query($query, $values, true);
		$data	= mysql_fetch_assoc($result);

		mysql_free_result($result);
		return $data;
	}

 
 	function getValue($query, $values = array(), $default = false) 
	{
		$result	= $this->query($query, $values, true);
		$data	= mysql_fetch_row($result);
		
		mysql_free_result($result);
		return is_array($data) ? $data[0] : $default;
	}


	function getColumn($query, $values = array(), $col = 'id') 
	{
		$result = $this->query($query, $values, true);
		$data	= array();
		
		while ($row = mysql_fetch_assoc($result))
		{
			$data[] = $row[$col];
		}

		mysql_free_result($result);
		return $data;
	}
 
 
	function getLastQuery() 
	{
		return $this->lastquery;
	}


 	function quoteSmart($text, $quoteNumbers = false)
	{
		return (is_numeric($text) && !$quoteNumbers) || $text == 'NULL' ? $text : "'".mysql_real_escape_string($text, $this->db)."'";
	}
	
	public function createTable($name, $fields, $primarykey, $indexes = array(), $engine='InnoDB')
	{
		$sql = "CREATE TABLE `$name` (";
		foreach($fields as $field){
			$sql .= "`".$field['name']."` ".$field['type'] . ($field['length'] > 0 ? "(".$field['length'].")" : "").( isset($field['extra']) ? $field['extra'] : '' ).",";
		}
		$sql .= "PRIMARY KEY ( `$primarykey` )";
		$sql .= count($indexes)>0 ? ", INDEX (`" . implode('`, `', $indexes) . "`)" : "";
		$sql .= ") ENGINE = $engine";
		
		$this->query($sql);
	}
	
	function existTable($name)
	{
		return mysql_query("DESC $name");
	}
	
	// iDatabase interface	
	public function hasContentDatabaseRelation($contenttype)
	{
		$contenttype = strtolower($contenttype);
		$res = mysql_query('SHOW TABLES', $this->db);
		$check = false;
		while($row = mysql_fetch_row($res)){
			if($row[0] == 'contentvalues_'.$contenttype)
				$check = true;
		}
		
		$res = $this->getValue('SELECT id FROM '.TABLE_CONTENTTYPES.' WHERE `name` = ? ', array($contenttype), false);
		return $res && $check;
	}
	
	public function createContentDatabaseRelation($contenttype, $type)
	{
		$contenttype = strtolower($contenttype);
		// Eintrag in die CONTENTTYPES Tabelle
		if(!$this->getValue('SELECT id FROM '.TABLE_CONTENTTYPES.' WHERE `name` = ? ', array($contenttype), false))
			$this->insert(TABLE_CONTENTTYPES, array('name' => $contenttype));

		// Anlegen ein Value Tabelle
		if(!$this->existTable('contentvalues_'.$contenttype)){
			$fields = array(
				array('name' => 'id', 				'type' => 'INT', 		'length' =>	11, 	'extra' => 'AUTO_INCREMENT'),
				array('name' => 'contenttype_id', 	'type' => 'INT', 		'length' =>	11),
				array('name' => 'page_id',	 		'type' => 'INT', 		'length' =>	11),
				array('name' => 'name',				'type' => 'VARCHAR', 	'length' =>	255),
				$this->getDriverFieldtype($type)
			);
			$this->createTable('contentvalues_'.$contenttype, $fields, $fields[0]['name'], array('contenttype_id', 'page_id'));
		}
				
	}
	
	public function getDriverFieldtype($type){
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
	
}

?>
