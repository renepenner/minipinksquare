<?php
class DatabaseSingleton
{
    private static $instance;
    
    private function __construct() {}

    /**
     * @return DatabaseSingleton
     */
    public static function singleton() 
    {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }
    
    /**
     * @return iDatabase
     */
    public function getDatabase()
    {
        return DatabaseFactory::factory(DB_TYPE);
    }

    // Halte Benutzer vom Klonen der Instanz ab
    public function __clone()
    {
        trigger_error('Klonen ist nicht erlaubt.', E_USER_ERROR);
    }
}
?>