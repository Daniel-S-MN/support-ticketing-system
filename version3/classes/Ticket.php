<?php

// TODO: need to update the class with the new database

require_once('classes/Database.php');

class Ticket extends Database {

    public $error;

    // Create a new ticket and add it to the DB
    function newTicket($con, $username, $priority, $title, $description) {

        // https://www.php.net/manual/en/mysqli.real-escape-string.php
        $cleanTitle = mysqli_real_escape_string($con, $title);
        $cleanDesc = mysqli_real_escape_string($con, $description);

        $sql = "INSERT INTO tickets (username, priority, title, description)
                VALUES ('$username', '$priority', '$cleanTitle', '$cleanDesc')";
        
        if (mysqli_query($con, $sql)) {
            // Ticket was successfully added to the DB
            return "Success";
        } else {
            $this->error = "ERROR: Unable add ticket to the database: " . mysqli_error($con);
        }
    }

    // Get the number of open/pending tickets for the user
    function getNumOpenPendingTickets($con, $username) {

        $query = "SELECT *
                  FROM tickets
                  WHERE username = '$username'
                  AND status != 'Closed'";
        
        if ($result = mysqli_query($con, $query)) {
            $count = mysqli_num_rows($result);
            return $count;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get the number of pending (unassigned) tickets in the DB
    function getNumPendingTickets($con) {

        $query = "SELECT *
                  FROM tickets
                  WHERE assigned_to IS NULL";
        
        if ($result = mysqli_query($con, $query)) {
            $count = mysqli_num_rows($result);
            return $count;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get the number of working (assigned) tickets in the DB
    function getNumWorkingTickets($con) {
        
        $query = "SELECT *
                  FROM tickets
                  WHERE assigned_to IS NOT NULL AND status != 'Closed'";
        
        if ($result = mysqli_query($con, $query)) {
            $count = mysqli_num_rows($result);
            return $count;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }
    
    // Get all the unassigned open tickets in the DB
    function getOpenTickets($con) {

        $query = "SELECT ticket_id, date_created, priority, username, title, description, status 
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

        $query = "SELECT ticket_id, date_created, priority, username, title, description, status, assigned_to 
                FROM tickets 
                WHERE assigned_to IS NOT NULL AND status != 'Closed'";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get all the tickets assigned to the IT Support user
    function getMyAssignedTickets($con, $username) {

        $query = "SELECT ticket_id, date_created, priority, username, title, description, status 
                FROM tickets 
                WHERE assigned_to = '$username' AND status = 'Pending'";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Assign an IT Support rep to a specific ticket
    function assignRep($con, $username, $ticketID) {

        $sql = "UPDATE tickets 
                SET assigned_to = '$username', status = 'Pending' 
                WHERE tickets.ticket_id = '$ticketID'";
        
        if (mysqli_query($con, $sql)) {
            // Ticket was successfully updated
            return "Success";
        } else {
            // There was a problem
            $this->error = "Unable to assign support rep: " . mysqli_error($con);
        }
    }

    // Get all the open/pending tickets for a user
    function getMyOpenTickets($con, $username) {

        $query = "SELECT ticket_id, date_created, username, priority, title, description, assigned_to, status 
                FROM tickets 
                WHERE username = '$username' AND status != 'Closed' 
                ORDER BY status DESC ";
        
        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get all the closed tickets for a user
    function getMyClosedTickets($con, $username) {

        $query = "SELECT ticket_id, date_created, username, priority, title, description, assigned_to, status 
                FROM tickets 
                WHERE username = '$username' AND status = 'Closed' ";
        
        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get the comments from a specific ticket
    function getComments($con, $ticketID) {

        $query = "SELECT *
                FROM comments
                WHERE ticket_id = '$ticketID'";
        
        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Add a new comment for a specific ticket
    function addComment($con, $ticketID, $username, $comment) {

        $message = mysqli_real_escape_string($con, $comment);

        $sql = "INSERT INTO comments (ticket_id, username, comment)
                VALUES ('$ticketID', '$username', '$message')";

        if (mysqli_query($con, $sql)) {
            // Comment was successfully added to the ticket
            return true;
        } else {
            $this->error = "ERROR: Unable add comment to ticket: " . mysqli_error($con);
            return false;
        }
    }

    // // Close a ticket
    // function closeTicket($con, $ticketID, $comment) {

    //     $message = mysqli_real_escape_string($con, $comment);

    //     $sql = "UPDATE tickets
    //             SET comments = CONCAT(IFNULL(comments,''), '$message'), status = 'Closed'
    //             WHERE ticket_id = '$ticketID'";

    //     if (mysqli_query($con, $sql)) {
    //         // Comment was successfully added to the ticket and closed
    //         return "Success";
    //     } else {
    //         $this->error = "ERROR: Unable add comment to ticket: " . mysqli_error($con);
    //     }

    // }

    // Get a specific ticket
    function getTicket($con, $ticketID) {

        $query = "SELECT * FROM tickets WHERE ticket_id = '$ticketID'";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }

}