<?php

    /*
     * This page will direct the user to the proper "main" page, based on their
     * department/position.
    */
    
    include('connection.php');

    session_start();

    if($_SESSION['Department'] != "IT Support") {

        header("Location: user_main.php");
    } else {

        if($_SESSION['Position'] != "Manager") {

            header("Location: it_support_main.php");
        } else {

            header("Location: it_manager_main.php");
        }
    }
    
?>