<?php
class DatabaseFactory
{
	/**
	 * Enter description here...
	 *
	 * @param string $type
	 * @return iDatabase
	 */
	static function factory($type)
	{		
		if (include_once 'Database/' . $type . '.php') {
            $classname = $type;
            return new $classname;
        } else {
            throw new Exception ('Treiber nicht gefunden');
        }
	}
}
?>