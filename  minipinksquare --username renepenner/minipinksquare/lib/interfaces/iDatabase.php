<?php
interface iDatabase
{
	public function connect();
	
	public function query($query);

	/**
	 * Enter description here...
	 *
	 * @param  $table
	 * @return boolean
	 */
	public function hasTable($table);
}
?>