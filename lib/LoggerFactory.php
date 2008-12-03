<?php
class LoggerFactory{

	/**
	 *
	 *
	 * @param string $type
	 * @return iLogger
	 */
	static function factory($type)
	{		
		if (require_once $type . '.php') {
            return new $type;
        } else {
            throw new Exception ('Logger nicht gefunden');
        }
	}
}
?>