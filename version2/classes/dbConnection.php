<?php

// Connection to the DB (see connection.php from version 1)

class dbConnection {
    private $userID = "root";
    private $password = "";
    private $host = "localhost";
    private $dbname = "prototypev1";

    public $mysql = "";
    public $error;

    // Open the connection to the DB
    function dbOpen() {
        $this->mysqli = new mysqli($this->host, $this->userID, $this->password, $this->dbname);

        // If it cann't connect, find out why
        if ($this->mysqli->connect_errno) {
            $this->error = "Connect Error: " . $this->mysqli->connect_errno;
            return false;
        } else {
            return $this->mysqli;
        }
    }

    // Close the current connection to the DB
    function dbClose() {
        $this->mysqli->close();

        return "Database connection has been closed.";
    }

    // Return the recent error
    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }

}