<?php

//require('classes/DBConn.php');

class Ticket {

    public $error;

    // Create a new ticket and add it to the DB
    function newTicket($con, $userID, $priority, $description) {

        $sql = "INSERT INTO tickets (priority, description, created_by)
                VALUES ('$priority', '$description', '$userID')";
        
        if (mysqli_query($con, $sql)) {
            // Ticket was successfully added to the DB
        } else {
            $this->error = "ERROR: Unable add ticket to the database: " . mysqli_error($con);
        }
    }
    
    // Get all the unassigned open tickets in the DB
    function getOpenTickets($con) {

        $query = "SELECT ticket_id, date_created, priority, user_id, description, status 
                FROM tickets 
                WHERE assigned_to IS NULL ";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysql_error();
            return NULL;
        }
    }

    // Get ALL the assigned pending tickets in the DB
    function getAllPendingTickets($con) {

    }

    // Get all the tickets assigned to the IT Support user
    function getMyAssignedTickets($con, $userID) {

    }

    // Search for a specific ticket
    function getTicket($con, $ticketID) {

    }

    // Close a ticket
    function closeTicket($con, $ticketID) {

    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }

}