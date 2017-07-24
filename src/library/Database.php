<?php

class Database
{
    private $_connection;
    // single instance
    private static $_instance; 
    private $_host = "localhost";
    private $_username = "username";
    private $_password = "password";
    private $_database = "customers";

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct()
    {
        try {

            $this->_connection = new PDO("mysql:host=$this->_host;dbname=$this->_database",
                "$this->_username", "$this->_password");

        } catch (PdoException $e) {

            echo $e->getMessage();

        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->_connection;
    }
}