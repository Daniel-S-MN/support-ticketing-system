<?php

session_start();

// Make sure only people logged in AND IT Support users can view this page

if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Department'] != 'IT Support') {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>Assigned Tickets</title>    
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        // Menu items will only display for the correct permissions of each user
        if ($_SESSION['Position'] != 'Manager') {
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
        <h3>This is where you can view the tickets that have been assigned to you.</h3>
        <div>

        <?php

        require('classes/Database.php');
        require('classes/Ticket.php');

        $db = new Database();
        $con = $db->connect();

        $ticket = new Ticket();

        $myID = $_SESSION['User_ID'];

        $myTickets = $ticket->getMyAssignedTickets($con, $myID);

        if ($myTickets != NULL) {

            echo "<form method='post'>";
            echo "<table border='2' cellpadding='2' cellspacing='2'>";
                echo "<tr bgcolor='#b3edff'>";
                echo "<th>Select</th>";
                echo "<th>Ticket ID</th>";
                echo "<th>Date Created</th>";
                echo "<th>Priority</th>";
                echo "<th>Created By</th>";
                echo "<th>Description</th>";
                echo "<th>Status</th>";
                echo "</tr>";

            while($tickets = mysqli_fetch_object($myTickets)) {

                echo "<tr>";
                echo "<td align='center'><input type='radio' name='id' value='".$tickets->ticket_id."' required></td>";
                echo "<td align='center'>$tickets->ticket_id</td>";
                echo "<td align='center'>$tickets->date_created</td>";
                echo "<td align='center'>$tickets->priority</td>";
                echo "<td align='center'>$tickets->created_by</td>";
                echo "<td>$tickets->description</td>";
                echo "<td align='center'>$tickets->status</td>";
                echo "</tr>";
            }

            echo "</table><br><br>";
            

        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            header("refresh:0; url=index.php");
        }
        
        ?>

    </div>

 </body>
</html>