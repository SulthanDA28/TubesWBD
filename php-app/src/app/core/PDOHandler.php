<?php

class PDOHandler
{
    private static $instance;

    private $pdo;

    private $user = DBUSER;
    private $password = DBPASSWORD;


    public function __construct()
    {
        $dsn = "pgsql:host=" . DBHOST .
               ";port=" . DBPORT .
               ";dbname=" . DBNAME .
               ";user=" . DBUSER .
               ";password=" . DBPASSWORD;
        
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $retry = CONNECT_RETRIES;
        while($retry){
            try {
                $retry--;
                $pdo = new PDO($dsn, $this->user, $this->password, $option);
                $this->pdo = $pdo;
            } catch (PDOException) {
                error_log('Retrying database connection (' . $retry . ')');
            }
            $retry = 0;
        }
        if(!isset($pdo)) {
            exit('[ERROR]: Could not connect to database. ');
        }

    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
          self::$instance = new static();
        }
        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
