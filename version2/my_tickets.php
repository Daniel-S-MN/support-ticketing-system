<?php

session_start();

// Make sure only people logged in can view this page

if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>My Tickets</title>    
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        // Menu items will only display for the correct permissions of each user
        if ($_SESSION['Department'] != 'IT Support') {
            // Customers
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } elseif ($_SESSION['Position'] != 'Manager') {
            // IT Support non-managers
            echo '<a href="open_tickets.php">Open Tickets</a>';
            echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } else {
            // IT Support Managers (admins)
            echo '<a href="open_tickets.php">Open Tickets</a>';
            echo '<a href="pending_tickets.php">Pending Tickets</a>';
            echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
            echo '<a href="system_users.php">System Users</a>';
            echo '<a href="new_user.php">New User</a>';
        }

        ?>

        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <h3>This is where you can view your tickets.</h3>
        <hr>
        <div>

        <?php

        require('classes/Database.php');
        require('classes/Ticket.php');

        $db = new Database();
        $con = $db->connect();

        $ticket = new Ticket();

        $myOpenTickets = $ticket->getMyOpenTickets($con, $_SESSION['User_ID']);

        if ($myOpenTickets != NULL) {

            // Display all the user's open/pending tickets in a table
            echo "<h2>My Open/Pending Tickets:</h2>";
            echo "<table border='2' cellpadding='2' cellspacing='2'>";
                echo "<tr bgcolor='#b3edff'>";
                echo "<th>Ticket ID</th>";
                echo "<th>Date Created</th>";
                echo "<th>Priority</th>";
                echo "<th>Description</th>";
                echo "<th>Assigned To</th>";
                echo "<th>Status</th>";
            echo "</tr>";

            while($ticketInfo = mysqli_fetch_object($myOpenTickets)) {

                echo "<tr>";
                echo "<td align='center'>$ticketInfo->ticket_id</td>";
                echo "<td align='center'>$ticketInfo->date_created</td>";
                echo "<td align='center'>$ticketInfo->priority</td>";
                echo "<td>$ticketInfo->description</td>";
                echo "<td align='center'>$ticketInfo->assigned_to</td>";
                echo "<td align='center'>$ticketInfo->status</td>";
                echo "</tr>";
            }

            echo "</table><br><hr>";

        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }

        $myClosedTickets = $ticket->getMyClosedTickets($con, $_SESSION['User_ID']);

        if ($myClosedTickets != NULL) {

            // Display all the user's closed tickets in a table
            echo "<h2>My Closed Tickets:</h2>";
            echo "<table border='2' cellpadding='2' cellspacing='2'>";
                echo "<tr bgcolor='#b3edff'>";
                echo "<th>Ticket ID</th>";
                echo "<th>Date Created</th>";
                echo "<th>Priority</th>";
                echo "<th>Description</th>";
                echo "<th>Assigned To</th>";
                echo "<th>Status</th>";
            echo "</tr>";

            while($closedInfo = mysqli_fetch_object($myClosedTickets)) {

                echo "<tr>";
                echo "<td align='center'>$closedInfo->ticket_id</td>";
                echo "<td align='center'>$closedInfo->date_created</td>";
                echo "<td align='center'>$closedInfo->priority</td>";
                echo "<td>$closedInfo->description</td>";
                echo "<td align='center'>$closedInfo->assigned_to</td>";
                echo "<td align='center'>$closedInfo->status</td>";
                echo "</tr>";
            }

            echo "</table><br><hr>";

        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }
        
        ?>

    </div>

 </body>
</html>