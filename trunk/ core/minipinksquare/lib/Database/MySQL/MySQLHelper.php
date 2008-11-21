<?php
class MySQLHelper{
	
	public $db;
	public $lastquery;
	
	public function __construct($host, $user, $pass, $name)
	{
		$db		= mysql_connect($host, $user, $pass) or die('Connection failed: '.mysql_error());
		$result	= mysql_select_db($name, $db) or die('Database error: '.mysql_error());

		mysql_set_charset("utf8", $db);

		$this->db = $db;
	}
	
	public function query($query, $values = array(), $returnResult = false) 
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

	public function insert($table, $data) 
	{
		foreach ($data as $key => $value)
		{
			$data[$key] = $this->quoteSmart($value);
		}
		
		$this->query('INSERT INTO '.$table.' (`'.implode('`, `', array_keys($data)).'`) VALUES ('.implode(', ', array_values($data)).')');
		return mysql_insert_id($this->db);
	}

	public function update($table, $where, $data) 
	{
		foreach ($data as $key => $value)
		{
			$data[$key] = '`'.$key.'`='.$this->quoteSmart($value);
		}

		$this->query('UPDATE '.$table.' SET '.implode(', ', $data).' WHERE '.$where);
		return mysql_affected_rows($this->db);
	}

	public function delete($table, $where) 
	{
		$this->query('DELETE FROM '.$table.' WHERE '.$where);
		return mysql_affected_rows($this->db);
	}

	public function getAll($query, $values = array()) 
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

	public function getRow($query, $values = array()) 
	{
		$result	= $this->query($query, $values, true);
		$data	= mysql_fetch_assoc($result);

		mysql_free_result($result);
		return $data;
	}
 
 	public function getValue($query, $values = array(), $default = false) 
	{
		$result	= $this->query($query, $values, true);
		$data	= mysql_fetch_row($result);
		
		mysql_free_result($result);
		return is_array($data) ? $data[0] : $default;
	}

	public function getColumn($query, $values = array(), $col = 'id') 
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
 
	public function getLastQuery() 
	{
		return $this->lastquery;
	}

 	private function quoteSmart($text, $quoteNumbers = false)
	{
		return (is_numeric($text) && !$quoteNumbers) || $text == 'NULL' ? $text : "'".mysql_real_escape_string($text, $this->db)."'";
	}
	
	public public function createTable($name, $fields, $primarykey, $indexes = array(), $engine='InnoDB')
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
	
	public function existTable($name)
	{
		return mysql_query("DESC $name") !== false;
	}

	public function hasValue($table, $column, $value)
	{
		$res = $this->getValue("SELECT $column FROM $table WHERE $column = ? ", array($value));
		return $res == $value;
	}

}
?>