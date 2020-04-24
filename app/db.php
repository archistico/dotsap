<?php

namespace App;

class DB extends \Prefab
{
    private static $_instance = null;
    private $dbconn = null;

    private function __construct()
    {
        /*
        $DB_HOST = '127.0.0.1';
        $DB_NAME = 'my_db_name';
        $DB_USER = 'my_db__user';
        $DB_PASS = 'my_db_passw';
        $DB_PORT = '';
        $CHARSET = 'utf8';
        $DB_PREFIX = '';

        $this->dbconn = new \DB\SQL(
            'mysql:host=' . $DB_HOST . ';port=' . $DB_PORT . ';dbname=' . $DB_NAME,
            $DB_USER,
            $DB_PASS,
            $options = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => FALSE
            )
        );
        */

        $DB_SQLITE_FILE = "db/database.sqlite";
        $this->dbconn = new \DB\SQL('sqlite:'.$DB_SQLITE_FILE);
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function connect()
    {
        if ($this->dbconn) {
            return $this->dbconn;
        } else echo '<br>DB: nessuna connessione :(';
    }
    
    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
