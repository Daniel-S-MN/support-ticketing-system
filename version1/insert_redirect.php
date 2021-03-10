<?php

    /*
     * Redirect the user back to the "create ticket" page
     * based on the user's profile permissions.
    */
    
    include('connection.php');

    session_start();

    if($_SESSION['Department'] != "IT Support") {

        header("Location: user_create_ticket.php");
    } else {

        if($_SESSION['Position'] != "Manager") {

            header("Location: is_support_create_ticket.php");
        } else {

            header("Location: it_manager_create_ticket.php");
        }
    }
    
?>