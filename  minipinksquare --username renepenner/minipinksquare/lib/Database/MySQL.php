<?php
class MySQL implements iDatabase 
{
	private $dblink;
	
	public function MySQL()
	{
		$this->connect();
	}
	
	public function connect()
	{
		$this->dblink = mysql_connect(DB_HOST, DB_USER, DB_PASS);
		if($this->dblink) {
			if(!mysql_select_db(DB_NAME, $this->dblink)) {
				echo "Datenbank ".DB_NAME." wurde nicht gefunden";
		  	}
		}
	}
	
	public function query($query)
	{
		$sql = "SELECT * FROM settings";
		$res = mysql_query($sql, $this->dblink);
		$row = mysql_fetch_array($res);
		return $row;
	}
	
	public function hasTable($table){
		$res = mysql_query('SHOW TABLES', $this->dblink);
		while($row = mysql_fetch_row($res)){
			if($row[0] == $table)
				return true;
		}
		return false;
	}
	
}
?>