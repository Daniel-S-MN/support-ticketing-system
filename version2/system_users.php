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
        <h3>Here are all of the users in the system.</h3>
        <div>
        <?php

        require('classes/Database.php');
        require('classes/User.php');

        $db = new Database();
        $con = $db->connect();

        $user = new User();

        $sysUsers = $user->getAllUsers($con);

        if ($sysUsers != NULL) {
            // Display all the system users in a table
            echo "<table border='2' cellpadding='2' cellspacing='2'>";
                echo "<tr bgcolor='#b3edff'>";
                echo "<th>User ID</th>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Email</th>";
                echo "<th>Phone #</th>";
                echo "<th>Department</th>";
                echo "<th>Position</th>";
                echo "</tr>";

            while($systemUsers = mysqli_fetch_object($sysUsers)) {

                echo "<tr>";
                echo "<td align='center'>$systemUsers->user_id</td>";
                echo "<td align='center'>$systemUsers->first_name</td>";
                echo "<td align='center'>$systemUsers->last_name</td>";
                echo "<td align='center'>$systemUsers->email</td>";
                echo "<td align='center'>$systemUsers->phone_number</td>";
                echo "<td align='center'>$systemUsers->department</td>";
                echo "<td align='center'>$systemUsers->position</td>";
                echo "</tr>";
            }

            echo "</table><br><br>";

        } else {
            // There was an issue with the mysql query
            $errormsg = $user->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }

        ?>
    </div>

 </body>
</html>