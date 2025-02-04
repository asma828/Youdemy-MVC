<?php

namespace Classes;

use PDO;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $dsn = 'pgsql:host=localhost;dbname=youdemy';
        $username = 'postgres';
        $password = '';
        $this->connection = new PDO($dsn, $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = (new Database())->getConnection();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
