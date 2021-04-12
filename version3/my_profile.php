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
 
  <title>My Information</title>    
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

        ?>
        
    </div>

 </body>
</html>