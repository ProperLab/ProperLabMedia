<?php
/**
* ProperLabMedia\DbConn
* © 2020 ProperLab - All Rights Reserved
*/
namespace ProperLabMedia;

/**
* Database connection handler
*
* Establishes foundational database connection and property assignment pulled from `dbconf.php` config file.
* This base class is extended or utilized by numerous other classes.
*/
class DbConn
{
    /**
    * Database name
    * @var string
    */
    private $db_name;
    /**
    * Database server hostname
    * @var string
    */
    private $host;
    /**
    * Database username
    * @var string
    */
    private $username;
    /**
    * Database password
    * @var string
    */
    private $password;
    /**
    * PDO Connection object
    * @var object
    */
    public $conn;
    /**
    * Table where basic data is stored
    * @var string
    */
    public $tbl_rooms;

    /**
     * Class constructor
     * Initializes PDO connection and sets object properties
     */
    public function __construct()
    {
        // Pulls tables from dbconf.php file
        require 'dbconf.php';
        $this->tbl_rooms = $tbl_rooms;

        // Connect to server and select database
        try {
            $this->conn = new \PDO('mysql:host='.$host.';dbname='.$db_name.';charset=utf8', $username, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

}
