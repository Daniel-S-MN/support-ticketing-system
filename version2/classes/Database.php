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

    function connect() {

        $con = @mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

        // Check the connection
        if (mysqli_connect_errno()) {
            // Can't connect to the DB
            $errormsg = "Unable to connect to the database: " . mysqli_connect_error();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            header("refresh:0; url=index.php");
            exit();

        } else {
            // Connection is good!
            return $con;
        }
    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }
}