<?php
    
    include('connection.php');

    session_start();

    if($_SESSION['Department'] != "IT Support") {
        header("Location: index.php");
        session_destroy();
    } elseif($_SESSION['Position'] != "Manager") {
        header("Location: index.php");
        session_destroy();
    }
    
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>IT Support User "System Users" Page</title>    
  <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="sidenav">
    <a href="it_manager_main.php">Home</a>
    <a href="it_manager_tickets.php">My Tickets</a>
    <a href="it_manager_open_tickets.php">Open Tickets</a>
    <a href="pending_tickets.php">Pending Tickets</a>
    <a href="it_manager_create_ticket.php">Create Ticket</a>
    <a href="it_manager_profile.php">User Profile</a>
    <a href="system_users.php">System Users</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
<h3>This is the testing "System Users" page for the IT Support Managers.</h3>
<br>

<?php

    $query = "SELECT user_id, first_name, last_name, email, phone_number, department, position 
        FROM users";
    $result = mysqli_query($con, $query) or die("Error processing query. ".mysql_error());

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

    while($systemUsers = mysqli_fetch_object($result)) {

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

    echo "<h3>Create New User</h3>";
    echo "<form action='add_user.php'>";
        echo "<label for='userID'>New user ID: </label>";
        echo "<input type='text' id='userID' name='userID' required><br><br>";
        echo "<label for='tempPswrd'>Temporary Password: </label>";
        echo "<input type='password' id='tempPswrd' name='tempPswrd' required><br><br>";
        echo "<label for='firstName'>First Name: </label>";
        echo "<input type='text' id='firstName' name='firstName' required><br><br>";
        echo "<label for='lastName'>Last Name: </label>";
        echo "<input type='text' id='lastName' name='lastName' required><br><br>";
        echo "<label for='userEmail'>User Email: </label>";
        echo "<input type='text' id='userEmail' name='userEmail' required><br><br>";
        echo "<label for='phoneNum'>Phone Number: </label>";
        echo "<input type='text' id='phoneNum' name='phoneNum' required><br><br>";
        echo "<label for='userDept'>Department: </label>";
        echo "<input type='text' id='userDept' name='userDept' required><br><br>";
        echo "<label for='userPost'>Position: </label>";
        echo "<input type='text' id='userPost' name='userPost' required><br><br>";
        echo "<input type='submit' value='Create New User'>";
    echo "</form>";

?>

</div>
</body>
</html>