<?php

session_start();

// Make sure only people logged in AND IT Support users can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Access'] < 2) {
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        // Menu items will only display for the correct permissions of each user
        if ($_SESSION['Access'] == 2) {
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
        <br><h4>These tickets are assigned to you for troubleshooting:</h4><br>
        <div>

        <?php

        require('classes/Ticket.php');

        $ticket = new Ticket();

        $con = $ticket->connect();

        $myID = $_SESSION['Username'];

        $myTickets = $ticket->getMyAssignedTickets($con, $myID);

        if ($myTickets != NULL) {

            echo "<style>";
            echo ".tablecenterheadCSS th, td{";
                echo "text-align:center;";
                echo "vertical-align: middle;";
                echo "}";
            echo "</style>";

            echo "<table class='tablecenterheadCSS table table-hover table-bordered'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'></th>";
                    echo "<th scope='col'>Ticket ID</th>";
                    echo "<th scope='col'>Date Created</th>";
                    echo "<th scope='col'>Priority</th>";
                    echo "<th scope='col'>Created By</th>";
                    echo "<th scope='col'>Title</th>";
                    echo "<th scope='col'>Description</th>";
                    echo "<th scope='col'>Status</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($tickets = mysqli_fetch_object($myTickets)) {
                echo "<tr>";
                    echo "<td><button type='button' class='btn btn-primary'>Troubleshoot</button></td>";
                    echo "<th scope='row'>$tickets->ticket_id</td>";
                    echo "<td>$tickets->date_created</td>";
                    echo "<td>$tickets->priority</td>";
                    echo "<td>$tickets->username</td>";
                    echo "<td>$tickets->title</td>";
                    echo "<td>$tickets->description</td>";
                    echo "<td>$tickets->status</td>";
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