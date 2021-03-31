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
        <h3>This is where you can add a new user to the system:</h3>
        <hr>
        <div>
        <?php

        echo "<h3>Create New User</h3>";
        echo "<form method='post'>";
            echo "<label for='userID'>New username: </label>";
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
            echo "<input type='submit' name='submit_new_user' value='Create New User'>";
        echo "</form>";

        ?>
    </div>

 </body>
</html>

<?php

if (isset($_POST['submit_new_user'])) {

    require('classes/User.php');

    $user = new User();

    $con = $user->connect();

    $userID = $_POST['userID'];
    $tempPass = $_POST['tempPswrd'];
    $fName = $_POST['firstName'];
    $lName = $_POST['lastName'];
    $email = $_POST['userEmail'];
    $phoneNum = $_POST['phoneNum'];
    $dept = $_POST['userDept'];
    $position = $_POST['userPost'];

    $status = $user->addUser($con, $userID, $tempPass, $fName, $lName, $email, $phoneNum, $dept, $position);

    if ($status != 'Success') {
        // User couldn't be added to the DB
        $errormsg = $user->getError();
        echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        $con->close();
        header("refresh:0; url=index.php");

    } else {
        // User was added to the DB
        $msg = "User was successfully added to the database!";
        echo '<script type="text/javascript">alert("'.$msg.'");</script>';
        $con->close();
        header("refresh:0; url=index.php");
    }
}

?>