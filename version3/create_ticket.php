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
 
  <title>Create New Ticket</title>    
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
        <h3>This is where you can create a new ticket.</h3>
        <hr>
        <h1>Submit a new ticket</h1>
        <form method="post">
        <label for="priority">Select the ticket priority level: </label>
        <select name="priority" id="priority" required>
            <option value="">-Select-</option>
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
        <br><br>
        <p>High: needs to be resolved within 1 business day.</p>
        <p>Medium: needs to be resolved within 2-3 business days.</p>
        <p>Low: needs to be resolved within 4-7 business days.</p>
        <br>
        <label for="title">Ticket Title:</lable><br>
        <textarea id="title" name="title" rows="2" cols="50" required></textarea><br><br>
        <label for="description">Ticket Description:</label><br>
        <textarea id="description" name="description" rows="10" cols="50" required></textarea>
        <br><br>
        <input type="submit" name="submit_ticket" value="Submit New Ticket"/>
        </form>
    </div>

 </body>
</html>

<?php

if (isset($_POST['submit_ticket'])) {

    require('classes/Ticket.php');

    $ticket = new Ticket();

    $con = $ticket->connect();

    $username = $_SESSION['Username'];

    $status = $ticket->newTicket($con, $username, $_POST['priority'], $_POST['title'], $_POST['description']);

    if ($status != 'Success') {
        // Ticket couldn't be added to the DB
        $errormsg = $ticket->getError();
        echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        $con->close();
        header("refresh:0; url=index.php");

    } else {
        // Ticket was added to the DB
        $msg = "Ticket was successfully submitted!";
        echo '<script type="text/javascript">alert("'.$msg.'");</script>';
        $con->close();
        header("refresh:0; url=my_tickets.php");
    }

}

?>