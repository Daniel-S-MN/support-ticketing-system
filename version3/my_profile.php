<?php

session_start();

// Make sure only people logged in can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
}

if (isset($_POST['update_password'])) {

    $username = $_SESSION['Username'];
    $newpassword = $_POST['new_password'];
    $verpassword = $_POST['verify_password'];

    // Make sure the the passwords match
    if($newpassword != $verpassword) {

        $message = "NEW PASSWORDS MUST MATCH";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {

        include ('classes/User.php');

        $user = new User();

        $con = $user->connect();

        $check = $user->changePassword($con, $username, $newpassword);

        // Verify if the password change was successful
        if ($check != "Success") {
            // Couldn't update the password
            $errormsg = $user->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        } else {
            // Password was successfully updated
            $msg = "Password updated";
            echo '<script type="text/javascript">alert("'.$msg.'");</script>';
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
 
  <title>My Profile</title>    
  
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/testing.css">
  
</head>
  <body>

    <div class="wrapper">
        <!-- The sidebar and navigation links -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>

                <?php

                    // Some menu items are only displayed based on the user permissions level
                    if ($_SESSION['Access'] == 1) {
                        // Non-IT Support users
                        echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
                        echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
                        echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';

                    } elseif ($_SESSION['Access'] == 2) {
                        // IT Support non-managers
                        echo '<li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>';
                            echo '<ul class="collapse list-unstyled" id="troubleshooting">';
                                echo '<li><a href="open_tickets.php">Open Tickets</a></li>';
                                echo '<li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>';
                            echo '</ul>';
                        echo '</li>';
                        echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
                        echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
                        echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';

                    } elseif ($_SESSION['Access'] == 3) {
                        // IT Support managers (admin)
                        echo '<li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>';
                            echo '<ul class="collapse list-unstyled" id="troubleshooting">';
                                echo '<li><a href="open_tickets.php">Open Tickets</a></li>';
                                echo '<li><a href="pending_tickets.php">Pending Tickets</a></li>';
                                echo '<li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>';
                            echo '</ul>';
                        echo '</li>';
                        echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
                        echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
                        echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';
                        echo '<li>';
                            echo '<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users" aria-hidden="true"></i> System Users</a>';
                            echo '<ul class="collapse list-unstyled" id="pageSubmenu">';
                                echo '<li><a href="system_users.php">View/Edit Users</a></li>';
                                echo '<li><a href="new_user.php">Create New User</a></li>';
                            echo '</ul>';
                        echo '</li>';
                    }

                ?>

                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- 
            Here is the page content and mobile menu bar. The mobile bar is only visible when the screen
            size is smaller. The main navbar from above will not be displayed as well.
        -->
        <div id="content">

            <!-- Mobile navbar (this is only intended for non-IT Support users) -->
            <nav class="d-block d-md-none navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <span class="navbar-brand mb-2 h1">Support Ticket System</span>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="create_ticket.php">Create Ticket</a></li>
                                <li class="nav-item"><a class="nav-link" href="my_tickets.php">My Tickets</a></li>
                                <li class="nav-item"><a class="nav-link" href="my_profile.php">My Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                </div>
            </nav>
                <h2>My Profile Information</h2><hr>
                <h4>Please submit a ticket if any of your information needs to be updated.</h4><br>
                <p>Username:  <?php echo $_SESSION['Username'];?></p>
                <p>Full Name:  <?php echo $_SESSION['First_Name'].' '.$_SESSION['Last_Name'];?></p>
                <p>Email:  <?php echo $_SESSION['Email'];?></p>
                <p>Phone Number:  <?php echo $_SESSION['Phone_Num'];?></p>
                <p>Department:  <?php echo $_SESSION['Department'];?></p>
                <p>Position:  <?php echo $_SESSION['Title'];?></p>
                <br><br>
                <p style="font-weight: bold;">Need to update/change your password?</p>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#passwordChange">Change Password</button>
                </a><br><br>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="passwordChange" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100">Change Your Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                <div class="form-group">
                    <label for="pswrd1">New Password:</label>
                    <input type="text" class="form-control" id="pswrd1" name="new_password" required></textarea>
                </div>
                <div class="form-group">
                    <label for="pswrd2">Verify Password:</label>
                    <input type="text" class="form-control" id="pswrd2" name="verify_password" required></textarea>
                </div>
                
            </div>
            <div class="modal-footer justify-content-between">
                <input type="submit" class="btn btn-info" name="update_password" value="Update Password">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
                </form>
            </div>
            
            </div>
        </div>

    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 </body>
</html>

<!--
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>My Information</title>    
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        /*
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
        <h3>This is where you can view your profile information and change your password.</h3>
        <hr>
        <h1>User Information</h1>
        <h3>If you need to update your contact information, please submit a ticket.</h3><br>
        <p style="font-weight: normal;">Username:  <?php echo $_SESSION['Username'];?></p>
        <p style="font-weight: normal;">Full Name:  <?php echo $_SESSION['First_Name'].' '.$_SESSION['Last_Name'];?></p>
        <p style="font-weight: normal;">Email:  <?php echo $_SESSION['Email'];?></p>
        <p style="font-weight: normal;">Phone Number:  <?php echo $_SESSION['Phone_Num'];?></p>
        <p style="font-weight: normal;">Department:  <?php echo $_SESSION['Department'];?></p>
        <p style="font-weight: normal;">Position:  <?php echo $_SESSION['Title'];?></p>
        <br><br>
        <p style="font-weight: bold;">Need to update/change your password?</p><br>
        <form method="post">
            <input type="submit" name="password_change" value="Change Password">
        </form>
        </a><br><br>

        <?php
        
        if (isset($_POST['password_change'])) {

            echo '<form method="post">';
            echo 'New Password: <input type="password" name="new_password" required><br><br>';
            echo 'Verify New Password: <input type="password" name="verify_password" required><br><br>';
            echo '<br><br>';
            echo '<input id="button" type="submit" name="update_password" value="Update Password"><br><br>';
            echo '</form>';
        }

        if (isset($_POST['update_password'])) {

            $username = $_SESSION['Username'];
            $newpassword = $_POST['new_password'];
            $verpassword = $_POST['verify_password'];

            // Make sure the the passwords match
            if($newpassword != $verpassword) {

                $message = "NEW PASSWORDS MUST MATCH";
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {

                include ('classes/User.php');

                $user = new User();

                $con = $user->connect();

                $check = $user->changePassword($con, $username, $newpassword);

                // Verify if the password change was successful
                if ($check != "Success") {
                    // Couldn't update the password
                    $errormsg = $user->getError();
                    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
                    $con->close();
                    header("refresh:0; url=index.php");
                } else {
                    // Password was successfully updated
                    $msg = "Password updated";
                    echo '<script type="text/javascript">alert("'.$msg.'");</script>';
                    $con->close();
                    header("refresh:0; url=index.php");
                }
            }

        }
        */
        ?>
        
    </div>

 </body>
</html>
-->