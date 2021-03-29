<?php

/*
 * Daniel Schwen
 * March 27, 2021
 * 
 * I'm planning on learning more about AJAX to try and reduce the amount of pages
 * that are used in the ticket system, but due to time constraints (iteration 3 is
 * due in a couple days), it will have to wait for the final product.
 * 
 * For now, I'm going to be using separate pages for:
 *  - Viewing all open/unassigned tickets
 *  - Creating a new ticket
 *  - Viewing your tickets
 *  - Viewing+working on tickets assigned to you
 *  - Viewing+reassigning pending tickets (Managers)
 *  - Viewing all users in the system and creating new users
 * 
 * Thanks to restricing view access, I no longer need multipe version of the above 
 * pages for each user type.
*/


session_start();

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
        <h3>This is the testing "Home" page for ALL users.</h3>
        <hr><br>
        <div>
        <?php
        echo 'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!';

        if ($_SESSION['Department'] == 'IT Support') {

            echo '<br><br><h3>Quick Look At Ticket Numbers:</h3>';
            echo '<br><br>[OPEN, PENDING, AND TICKETS ASSIGNED TO "YOU" WILL APPEAR HERE]<br><br>';
        } else {

            echo '<br><br><h3>Non-IT Support Users:</h3>';
            echo '<br><br>[THIS WILL BE A QUICK STATUS UPDATE FOR THE USER]<br><br>';
        }
        ?>
    </div>

 </body>
</html>