<?php

    // This is where all users can change their password.

    include('connection.php');

    session_start();

    if(isset($_POST['update_password'])) {
        
        $username = $_SESSION['User_ID'];
        $newpassword = $_POST['new_password'];
        $verpassword = $_POST['verify_password'];

        // Make sure the the passwords match
        if($newpassword != $verpassword) {

            $message = "NEW PASSWORDS MUST MATCH";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {

            $sql = "UPDATE users SET password=md5('$newpassword') WHERE users.user_id ='$username'";

            if(mysqli_query($con, $sql)) {
                
                $message2 = "PASSWORD SUCCESSFULLY UPDATED";
                echo "<script type='text/javascript'>alert('$message2');</script>";
                header("refresh: 0; url=redirect.php");
            } else {

                $message3 = "ERROR: Unable to execute $sql. " . mysqli_error($con);
                echo "<script type='text/javascript'>alert('$message3');</script>";
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>ALL Users "Change Password" Page</title>    
  <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="sidenav">
    <a href="redirect.php">Home</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
    <h3>This is the testing "Change Password" page for ALL users.</h3>
    <h1>Update your password</h1>
    <form method="post">
        New Password: <input type="password" name="new_password" required><br><br>
        Verify New Password: <input type="password" name="verify_password" required><br><br>
        <br><br>
        <input id="button" type="submit" name="update_password" value="Update Password"><br><br>
    </form>
</div>

</body>
</html>