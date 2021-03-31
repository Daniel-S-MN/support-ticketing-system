<?php

if (isset($_POST['post_login'])) {

    require('classes/User.php');

    $user = new User();

    $con = $user->connect();

    if($user->login($con, $_POST['posted_username'], $_POST['posted_password'])) {
        $con->close();
        // Send the user to the correct main page, based on department and/or position
        header("Location: index.php");
    } else {
        // Incorrect user ID or password
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
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>Login - Support Ticket System</title>
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
      h3{color:white;}
      body {
          background-image: url('./images/Metropolitan_State_University_New_Main.jpg');
          background-repeat: no-repeat;
          background-size: cover;
      }
  </style>

</head>
<body>

<body>

    <form class="login" method="post">
        <h3>Support Ticket System</h3><br>
        
        <div class="loginInput">
            <i class="fa fa-user-circle-o icon fa-lg"></i>
            <input class="testField" type="text" name="posted_username" placeholder="User ID" required>
        </div>
            
        <div class="loginInput">
            <i class="fa fa-lock icon fa-lg"></i>
            <input class="testField" type="password" name="posted_password" placeholder="Password" required>
        </div>
        
        <input class="loginButton" type="submit" name="post_login" value="Login" style="cursor:pointer"><br>

        <!--  Password reset link will be added to version 3 -->
        
        <p><a href="">Forgot Password?</a></p>
            
    </form>

</body>

</html>