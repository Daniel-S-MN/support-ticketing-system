<?php

class DBConn {

    // The connection variables.
	private $dbhost = "localhost";
    private $dbuser = "root";
    private $dbpass = "";
    private $dbname = "prototypev2";

	public $connection = "";
	public $error;

	function connect() {
        $this->connection = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);

        if ($this->connection->connect_errno) {
            $this->error = "Failed to connect to MySQL: " . $this->$connection -> connect_error;
            //return false;
        } else {
            return $this->connection;
        }
    }

    function dbClose() {
        mysqli_close($this->connection);
    }

    function getError() {
        $error = $this->error;
		unset($this->error);
		return $error;
    }

}