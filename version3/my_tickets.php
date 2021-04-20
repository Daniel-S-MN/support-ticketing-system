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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        
        // Some menu items are only displayed based on the user permissions level
        if ($_SESSION['Access'] == 1) {
            // Non-IT Support users
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } elseif ($_SESSION['Access'] == 2) {
            // IT Support non-managers
            echo '<a href="open_tickets.php">Open Tickets</a>';
            echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } elseif ($_SESSION['Access'] == 3) {
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
        <br><h4>This is where you can view your tickets.</h4><br>
        <div>

        <?php

        require('classes/Ticket.php');

        $ticket = new Ticket();

        $con = $ticket->connect();

        $myOpenTickets = $ticket->getMyOpenTickets($con, $_SESSION['Username']);

        if ($myOpenTickets != NULL) {

            echo "<style>";
            echo ".tablecenterheadCSS th, td{";
                echo "text-align:center;";
                echo "vertical-align: middle;";
                echo "}";
            echo "</style>";

            // Display all the user's open/pending tickets in a table
            echo "<h4>My Open/Pending Tickets:</h4>";
            echo "<table class='tablecenterheadCSS table table-hover table-bordered'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'>Ticket ID</th>";
                    echo "<th scope='col'>Date Created</th>";
                    echo "<th scope='col'>Priority</th>";
                    echo "<th scope='col'>Title</th>";
                    echo "<th scope='col'>Description</th>";
                    echo "<th scope='col'>Assigned To</th>";
                    echo "<th scope='col'>Status</th>";
                    echo "<th scope='col'>Edit</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($ticketInfo = mysqli_fetch_object($myOpenTickets)) {
                echo "<tr>";
                    echo "<th scope='row'>$ticketInfo->ticket_id</td>";
                    echo "<td>$ticketInfo->date_created</td>";
                    echo "<td>$ticketInfo->priority</td>";
                    echo "<td>$ticketInfo->title</td>";
                    echo "<td>$ticketInfo->description</td>";
                    echo "<td>$ticketInfo->assigned_to</td>";
                    echo "<td>$ticketInfo->status</td>";
                    echo "<td><button type='button' class='btn btn-primary'>Edit</button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }

        $myClosedTickets = $ticket->getMyClosedTickets($con, $_SESSION['Username']);

        if ($myClosedTickets != NULL) {

            // Display all the user's closed tickets in a table
            echo "<br><h4>My Closed Tickets:</h4>";
            echo "<table class='tablecenterheadCSS table table-hover table-bordered'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'>Ticket ID</th>";
                    echo "<th scope='col'>Date Created</th>";
                    echo "<th scope='col'>Priority</th>";
                    echo "<th scope='col'>Title</th>";
                    echo "<th scope='col'>Description</th>";
                    echo "<th scope='col'>Assigned To</th>";
                    echo "<th scope='col'>Status</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($ticketInfo = mysqli_fetch_object($myClosedTickets)) {
                echo "<tr>";
                    echo "<th scope='row'>$closedInfo->ticket_id</td>";
                    echo "<td>$closedInfo->date_created</td>";
                    echo "<td>$closedInfo->priority</td>";
                    echo "<td>$closedInfo->title</td>";
                    echo "<td>$closedInfo->description</td>";
                    echo "<td>$closedInfo->assigned_to</td>";
                    echo "<td>$closedInfo->status</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            
        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }
        
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
 </body>
</html>