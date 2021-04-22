<?php

session_start();

// Make sure only people logged in AND IT Support managers can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Access'] != 3) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>Create New User</title>    
  
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/stylesheet.css">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
  
</head>
  <body>

    <div class="wrapper">
        <!-- The sidebar and navigation links -->
        <nav id="desktopNav">
            <ul class="list-unstyled components">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                <li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>
                    <ul class="collapse list-unstyled" id="troubleshooting">
                        <li><a href="open_tickets.php">Open Tickets</a></li>
                        <li><a href="pending_tickets.php">Pending Tickets</a></li>
                        <li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>
                    </ul>
                </li>
                <li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>
                <li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>
                <li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>
                <li><a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users" aria-hidden="true"></i> System Users</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="system_users.php">View/Edit Users</a></li>
                        <li><a href="new_user.php">Create New User</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- 
            Here is the page content and mobile menu bar. The mobile bar is only visible when the screen
            size is smaller. The main navbar from above will not be displayed as well.
        -->
        <div id="content">

            <!-- Mobile navbar (this is only intended for non-IT Support users) -->
            <nav class="d-block d-md-none navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <span class="navbar-brand mb-2 h1">Support Ticket System</span>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                                <li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>
                                <li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>
                                <li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                            </ul>
                        </div>
                </div>
            </nav>
            
            <h2>New System User</h2><hr>
            <!-- Display all the users currently in the DB -->
            <?php
       
            ?>
            <form>
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputPassword4">Temp Password</label>
                    <input type="password" class="form-control" id="inputPassword4" placeholder="Temp Password" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="inputCity">City</label>
                    <input type="text" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-2">
                    <label for="inputState">Access Level</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option value="1">1 (non-IT Support)</option>
                        <option value="2">2 (IT non-manager)</option>
                        <option value="2">3 (IT manager)</option>
                    </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-info">Create New User</button>
            </form>

        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>

 </body>
</html>

<!--
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
        /*
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
            echo "<input type='text' id='userPost' name='userTitle' required><br><br>";
            echo "<label for='levels'>Select the new user's access level: </lable>";
            echo "<select name='levels' id='levels' required>";
            echo "<option value=''>--Select--</option>";
            echo "<option value='1'>1 (non-IT Support)</option>";
            echo "<option value='2'>2 (IT Support non-manager)</option>";
            echo "<option value='3'>3 (IT Support manager)</option>";
            echo "</select><br><br>";
            echo "<input type='submit' name='submit_new_user' value='Create New User'>";
        echo "</form>";

        ?>
    </div>

 </body>
</html>
-->

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
    $title = $_POST['userTitle'];
    $level = $_POST['levels'];

    $status = $user->addUser($con, $userID, $tempPass, $fName, $lName, $email, $phoneNum, $dept, $title, $level);

    if ($status != 'Success') {
        // User couldn't be added to the DB
        $errormsg = $user->getError();
        echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        $con->close();
        header("refresh:0; url=index.php");

    } else {
        // User was added to the DB, now flag the user as a new user in the DB
        $flagged = $user->flagNewUser($con, $userID);

        if ($flagged != 'Success') {
            // The user couldn't be added to the userstatus table in the DB
            $errormsg = $user->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        } else {
            $msg = "User was successfully added to the database!";
            echo '<script type="text/javascript">alert("'.$msg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }
    }
}
*/
?>