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
 
  <title>Pending Tickets</title>    
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
        <h3>Tickets currently assigned to an IT Support rep:</h3>
        <hr><br>
        <div>

        <?php

        // require('classes/Database.php');
        require('classes/Ticket.php');
        require('classes/User.php');

        // $db = new Database();
        // $con = $db->connect();

        $ticket = new Ticket();

        $con = $ticket->connect();

        $user = new User();

        $openTickets = $ticket->getAllPendingTickets($con);

        if ($openTickets != NULL) {

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
                echo "<th>Assigned To</th>";
                echo "</tr>";

            while($tickets = mysqli_fetch_object($openTickets)) {

                echo "<tr>";
                echo "<td align='center'><input type='radio' name='id' value='".$tickets->ticket_id."' required></td>";
                echo "<td align='center'>$tickets->ticket_id</td>";
                echo "<td align='center'>$tickets->date_created</td>";
                echo "<td align='center'>$tickets->priority</td>";
                echo "<td align='center'>$tickets->user_id</td>";
                echo "<td>$tickets->description</td>";
                echo "<td align='center'>$tickets->status</td>";
                echo "<td align='center'>$tickets->assigned_to</td>";
                echo "</tr>";
            }

            echo "</table><br><hr><br>";
            // Find all the IT Support users
            $availAgents = $user->getDepartment($con, "IT Support");

            if ($availAgents != NULL) {
                echo "<label for='it_users'>Select IT Support user to assign ticket to: </label>";
                echo "<select name='it_users' id='it_users' required>";
                echo "<option value=''>-Select User-</option>";

                while($ticket2 = mysqli_fetch_object($availAgents)) {

                    echo "<option value='".$ticket2->user_id."'>".$ticket2->user_id."</option>";
                }

                echo "</select><br><br>";
                echo "<input type='submit' name='assign' value='Assign Ticket'/>";
                echo "</form>";

            } else {
                $agentError = $user->getError();
                echo '<script type="text/javascript">alert("'.$agentError.'");</script>';
                $con->close();
                header("refresh:0; url=index.php");
            }

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

<?php

    if (isset($_POST['assign'])) {

        //require('classes/Database.php');
        //require('classes/Ticket.php');
        $agent = $_POST['it_users'];
        $ticketID = $_POST['id'];
        $check = $ticket->assignRep($con, $agent, $ticketID);
        if ($check != 'Success') {
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        } else {
            $msg = "Ticket updated successfully";
            echo '<script type="text/javascript">alert("'.$msg.'");</script>';
            $con->close();
            header("refresh:0; url=pending_tickets.php");
        }
    }

?>