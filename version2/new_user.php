<?php

session_start();

// Make sure only people logged in AND IT Support managers can view this page

if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Department'] != 'IT Support' || $_SESSION['Position'] != 'Manager') {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>System Users</title>    
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>
        <a href="open_tickets.php">Open Tickets</a>
        <a href="pending_tickets.php">Pending Tickets</a>
        <a href="assigned_tickets.php">Assigned Tickets</a>
        <a href="create_ticket.php">Create Ticket</a>
        <a href="my_tickets.php">My Tickets</a>
        <a href="my_profile.php">My Profile</a>
        <a href="system_users.php">System Users</a>
        <a href="new_user.php">New User</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <h3>This is where you can add a new user to the system.</h3>
        <div>
        <?php
        //echo 'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!';
        ?>
    </div>

 </body>
</html>