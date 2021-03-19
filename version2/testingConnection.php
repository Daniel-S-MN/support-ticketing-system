<?php

    /*
     * This file is just to setup a connection to the DB and to be used
     * in other pages for any MySQL query or to add/edit table data.
    */

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "prototypev1";
    
    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
        die("Falied to connect to the database");
    }

?>