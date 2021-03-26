<?php

// Just testing to see if I can even get going with using classes for version 2 of the prototype

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
 
  <title>Index for Version 2</title>    
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        // Menu items will only display for the correct permissions of each user
        if ($_SESSION['Department'] != 'IT Support') {
            // Customers
            echo '<a href="index.php">Create Ticket</a>';
            echo '<a href="index.php">My Tickets</a>';
            echo '<a href="index.php">My Profile</a>';
        } elseif ($_SESSION['Position'] != 'Manager') {
            // IT Support non-managers
            echo '<a href="index.php">Open Tickets</a>';
            echo '<a href="index.php">Assigned Tickets</a>';
            echo '<a href="index.php">Create Ticket</a>';
            echo '<a href="index.php">My Tickets</a>';
            echo '<a href="index.php">My Profile</a>';
        } else {
            // IT Support Managers (admins)
            echo '<a href="index.php">Open Tickets</a>';
            echo '<a href="index.php">Pending Tickets</a>';
            echo '<a href="index.php">Assigned Tickets</a>';
            echo '<a href="index.php">Create Ticket</a>';
            echo '<a href="index.php">My Tickets</a>';
            echo '<a href="index.php">My Profile</a>';
            echo '<a href="index.php">System Users</a>';
            echo '<a href="index.php">New User</a>';
        }

        ?>

        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <h3>This is the testing "Home" page for ALL users.</h3>
        <div>
        <?php
        echo 'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!';
        ?>
    </div>

 </body>
</html>