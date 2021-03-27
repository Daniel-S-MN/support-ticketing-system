<?php

session_start();

// Make sure only people logged in AND in IT Support can view this page

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
 
  <title>Open Tickets</title>    
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
            echo '<a href="index.php">Assigned Tickets</a>';
            echo '<a href="index.php">Create Ticket</a>';
            echo '<a href="index.php">My Tickets</a>';
            echo '<a href="index.php">My Profile</a>';
        } else {
            // IT Support Managers (admins)
            echo '<a href="open_tickets.php">Open Tickets</a>';
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
        <h3>Please select an open ticket to begin troubleshooting.</h3>
        <br>

        <?php

        /*
        * This is just a temporary workaround to be able to assign an open ticket to the IT Support
        * user. In the next iteration, I'll be integrating BootStrap, which will work MUCH more 
        * smoothly for interacting with the tickets table in the DB.
        * 
        * Source:
        * https://www.daniweb.com/programming/web-development/threads/331121/use-radio-button-to-select-row-of-returned-query-data
        */

        $query = "SELECT ticket_id, date_created, priority, created_by, description, status FROM 
            tickets WHERE assigned_to IS NULL ";

        $result = mysqli_query($con, $query) or die("Error processing query. ".mysql_error());

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

        while($ticket = mysqli_fetch_object($result)) {

            echo "<tr>";
            echo "<td align='center'><input type='radio' name='id' value='".$ticket->ticket_id."' required></td>";
            echo "<td align='center'>$ticket->ticket_id</td>";
            echo "<td align='center'>$ticket->date_created</td>";
            echo "<td align='center'>$ticket->priority</td>";
            echo "<td align='center'>$ticket->created_by</td>";
            echo "<td>$ticket->description</td>";
            echo "<td align='center'>$ticket->status</td>";
            echo "</tr>";
        }


        // Different options based on permissions
        if ($_SESSION['Position'] != 'Manager') {
            // IT Support non-managers
            echo "</table><br><br>";
            echo "<input type = 'submit' name = 'assign' value = 'Assign Ticket'><br><br>";
            echo "</form>";
        } else {
            // IT Support Managers (admins)
            echo "</table><br><br>";
            // Find all the IT Support users
            $query2 = "SELECT user_id FROM users WHERE department='IT Support'";
            $result2 = mysqli_query($con, $query2) or die("Error processing query. ".mysql_error());

            echo "<label for='it_users'>Select IT Support user to assign ticket to: </label>";
            echo "<select name='it_users' id='it_users' required>";
            echo "<option value=''>-Select User-</option>";

            while($ticket2 = mysqli_fetch_object($result2)) {

                echo "<option value='".$ticket2->user_id."'>".$ticket2->user_id."</option>";
            }

            echo "</select><br><br>";
            echo "<input type='submit' name='assign' value='Assign Ticket'/>";
            echo "</form>";
        }

        ?>

    </div>

 </body>
</html>