<?php

require('classes/User.php');
require_once('functions.php');

$user = new User();
$con = $user->connect();

if (isset($_POST['post_login'])) {

  if ($user->login($con, $_POST['posted_username'], $_POST['posted_password'])) {
    
    // Check if the user is flagged for a password reset in the DB
    if ($user->passwordResetCheck($con, $_POST['posted_username'])) {

      // The user needs to update their password
      echo '<script type="text/javascript">alert("Please update your password");</script>';
      $con->close();
      header("refresh:0; url=my_profile.php");
    } else {

      $con->close();
      // Send the user to the correct main page, based on department and/or position
      header("Location: index.php");
    }
  } else {

    // Incorrect username or password
    $errormsg = $user->getError();
    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
    $con->close();
    header("refresh:0; url=index.php");
    exit();
  }    
    
}

/**
 * Before you can send out emails, you need to configure XAMPP. I found
 * a very helpful and detailed explanation here:
 * 
 * https://stackoverflow.com/questions/15965376/how-to-configure-xampp-to-send-mail-from-localhost
 * 
 */

if (isset($_POST['password_reset'])) {

  if ($user->forgotPasswordCheck($con, $_POST['checkUsername'], $_POST['checkEmail'])) {

    $username = $_POST['checkUsername'];
    $userEmail = $_POST['checkEmail'];

    $tempPassword = getTempPassword();

    // Verify that the password was udpated in the DB
    if ($check = $user->changePassword($con, $username, $tempPassword)) {
      // Flag the user's account as needing to update their password when they log back in
      if ($flag = $user->flagPswdReset($con, $username)) {
        // Send the new temporary password to the user via email
        if (sendRecoveryEmail($userEmail, $tempPassword)) {
          // Email was successfully sent
          echo '<script type="text/javascript">alert("A temporary password has been sent to your email.");</script>';
          header("refresh:0; url=index.php");
        } else {
          // Couldn't send the email
          echo '<script type="text/javascript">alert("Message could not be sent...");</script>';
          header("refresh:0; url=index.php");
        }
      } else {
        // Shouldn't be possible, but whatever
        $errormsg = $user->getError();
        echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        $con->close();
        header("refresh:0; url=index.php");
        exit();
      }
    }

  } else {

    // Incorrect username or password
    $errormsg = $user->getError();
    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
    $con->close();
    header("refresh:0; url=index.php");
    exit();
  }
}

/*
 * Here is the source for the background image:
 * By McGhiever - Own work, CC BY-SA 4.0, https://commons.wikimedia.org/w/index.php?curid=79432904
*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <title>Login - Support Ticket System</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome (for the icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
  <!-- Our CSS file for the site after the login page -->
  <link rel="stylesheet" href="styles/login.css">

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/css/jasny-bootstrap.min.css">
  
</head>

<!-- This is the background image for the login page. I have no idea why it doesn't work in the CSS file but it doesn't, so here it is. -->
<style>
    body{
        background-image: url('./images/Metropolitan_State_University_New_Main_V2.jpg');
        background-repeat: no-repeat;
        background-size: auto;
        background-position: center center;
        padding-top: 25vh;
    }
</style>

<body>

  <!-- Login Form -->
  <div class="login-form">
    <form method="post">
      <h4 class="text-white text-center font-weight-bold">Support Ticket System</h4><br>
        <div class="form-group">
          <i class="fa fa-user-circle-o icon fa-lg"></i>
          <input type="text" class="form-control" name="posted_username" placeholder="Username" required>
        </div>
        <div class="form-group">
          <i class="fa fa-lock icon fa-lg"></i>
          <input type="password" class="form-control" name="posted_password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-info btn-block" name="post_login">Login</button>
        </div>
        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#pswrdModal">Forgot Password?</button>
    </form>
  </div>

  <!-- "Forgot Password" modal -->
  <div id="pswrdModal" class="modal fade">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h3 class="modal-title w-100">Forgot Password - Verify Identity</h3>
        </div>
        <form role="form" method="post">
          <div class="modal-body">
              <div class="form-group">
                <label for="checkUsername">Username</label>
                <div>
                  <input type="text" class="form-control" id="checkUsername" name="checkUsername" required>
                </div>
              </div>
              <div class="form-group">
                <label for="checkEmail">Email Address</label>
                <div>
                  <input type="email" class="form-control" id="checkEmail" name="checkEmail" required>
                </div>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-info mr-auto" name="password_reset">Request Password Reset</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Latest stable version of jQuery (required for Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
</body>

</html>