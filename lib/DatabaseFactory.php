<?php
class DatabaseFactory
{
	/**
	 *
	 *
	 * @param string $type
	 * @return iDatabase
	 */
	static function factory($type)
	{		
		if (require_once 'Database/' . $type . '.php') {
            set_include_path(get_include_path() . PATH_SEPARATOR . PATH_LIB . 'Database/'. $type.'/');
            return new $type;
        } else {
            throw new Exception ('Treiber nicht gefunden');
        }
	}
}
?>