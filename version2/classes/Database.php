<?php

class Database {

    private $dbhost;
    private $dbuser;
    private $dbpass;
    private $dbname;

    public $error;

    function __construct()
    {
        $this->dbhost = "localhost";
        $this->dbuser = "root";
        $this->dbpass = "";
        $this->dbname = "prototypev2";
    }

    function connect()
    {
        if (!$con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname)) {
            die("Failed to connect to the database");
        } else {
            return $con;
        }
    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }
}