<?php

session_start();
require_once('functions.php');

// Make sure only people logged in AND IT Support managers can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Access'] != 3) {
    header("Location: index.php");
}

// Attempt to add the new user to the DB after clicking the "Create New User" button
if (isset($_POST['submit_new_user'])) {

    // Make sure the temporary password is correct
    if ($_POST['tempPswrd'] != $_POST['tempPswrd2']) {

        echo '<script type="text/javascript">alert("Temporary passwords must match!");</script>';
        header("refresh:0; url=new_user.php");
    } else {

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

        // Try to add the new user to the DB
        if ($status = $user->addUser($con, $userID, $tempPass, $fName, $lName, 
            $email, $phoneNum, $dept, $title, $level)) {
            
            // User was added to the DB, now flag the user as a new user in the DB
            if ($flagged = $user->flagNewUser($con, $userID)) {

                // User was successfully flagged as a new user in the DB
                $msg = "User was successfully added to the database!";
                echo '<script type="text/javascript">alert("'.$msg.'");</script>';
                $con->close();
                header("refresh:0; url=index.php");
            } else {

                // The user couldn't be added to the userstatus table in the DB
                $errormsg = $user->getError();
                echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
                $con->close();
                header("refresh:0; url=index.php");
            }
        } else {

            // User couldn't be added to the DB
            $errormsg = $user->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }
    }

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>Create New User</title>    
  
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/stylesheet.css">
    
</head>
  <body>

    <div class="wrapper">
        <!-- The sidebar and navigation links -->
        <nav id="desktopNav">
            <ul class="list-unstyled components">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                <?php showITManagerMenu(); ?>
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
            <!-- Add a new user to the DB -->
            <form method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="inputFName">First Name</label>
                    <input type="text" class="form-control" id="inputFName" name="firstName" placeholder="First name" required>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputLName">Last Name</label>
                    <input type="text" class="form-control" id="inputLName" name="lastName" placeholder="Last name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="inputEmail">User Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="userEmail" placeholder="Email" required>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputPhone">Phone Number</label>
                    <input type="text" class="form-control" id="inputPhone" name="phoneNum" placeholder="(###) ###-####" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="inputDepartment">Department</label>
                    <input type="text" class="form-control" id="inputDepartment" name="userDept" placeholder="Department" required>
                    </div>
                    <div class="form-group col-md-4">
                    <label for="inputTitle">Title</label>
                    <input type="text" class="form-control" id="inputTitle" name="userTitle" placeholder="Title" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputPassword1">Temporary Password</label>
                        <input type="password" class="form-control" id="inputPassword1" name="tempPswrd" placeholder="Temp password" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword2">Verify Password</label>
                        <input type="password" class="form-control" id="inputPassword2" name="tempPswrd2" placeholder="Temp password" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" name="userID" placeholder="first initial + last name" required>
                    </div>
                    <div class="form-group col-md-2">
                    <label for="inputState">Access Level</label>
                    <select id="inputState" name="levels" class="form-control" required>
                        <option selected>Choose...</option>
                        <option value="1">1 (non-IT Support)</option>
                        <option value="2">2 (IT non-manager)</option>
                        <option value="2">3 (IT manager)</option>
                    </select>
                    </div>
                </div><br>
                <button type="submit" class="btn btn-info" name='submit_new_user'>Create New User</button>
            </form>
            
        </div>
    </div>

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
 </body>
</html>