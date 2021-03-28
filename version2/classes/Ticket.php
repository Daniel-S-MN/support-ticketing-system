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
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get ALL the assigned pending tickets in the DB
    function getAllPendingTickets($con) {

        $query = "SELECT ticket_id, date_created, priority, user_id, description, status 
                FROM tickets 
                WHERE assigned_to IS NOT NULL ";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get all the tickets assigned to the IT Support user
    function getMyAssignedTickets($con, $userID) {

        $query = "SELECT ticket_id, date_created, priority, user_id, description, status 
                FROM tickets 
                WHERE assigned_to = '$userID' AND status = 'Pending'";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }

    }

    // Assign an IT Support rep to a specific ticket
    function assignRep($con, $userID, $ticketID) {

        $sql = "UPDATE tickets 
                SET assigned_to = '$userID'  
                WHERE tickets.ticket_id = '$ticketID'";
        
        if (mysqli_query($con, $sql)) {
            // Ticket was successfully updated
            return "Success";
        } else {
            // There was a problem
            $this->error = "Unable to assign support rep: " . mysqli_error($con);
        }
    }

    // Close a ticket
    function closeTicket($con, $userID, $ticketID) {

        $sql = "UPDATE tickets 
                SET status = Closed , assigned_to = '$userID' 
                WHERE tickets.ticket_id = $ticketID";

        if (mysqli_query($con, $sql)) {
            // Ticket was successfully updated
            return "Success";
        } else {
            // There was a problem
            $this->error = "Unable to close the ticket: " . mysqli_error($con);
        }

    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }

}