<?php

session_start();

// Make sure only people logged in can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes")
{
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
 
  <title>Support Ticket System</title>    
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

        <?php

            echo "<h3>".'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!' . "</h3>";
            echo "<hr>";
            echo "<div>";

            if ($_SESSION['Access'] > 1) {

                echo "<h3>Here is a quick break-down of what's going on:</h3>";

                require('classes/Ticket.php');

                $ticket = new Ticket();

                $con = $ticket->connect();

                $numOpen = $ticket->getNumPendingTickets($con);
                $numPend = $ticket->getNumWorkingTickets($con);

                echo "<h3>Number of open tickets: ".$numOpen."</h3>";
                echo "<h3>Number of pending tickets: ".$numPend."</h3>";
            }

        ?>

    </div>

 </body>
</html>