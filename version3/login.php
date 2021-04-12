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
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
  <title>Login - Support Ticket System</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles/login.css">
  
</head>

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
    
    <div class="login-form">
        <form method="post">
            <h3 class="text-center">Support Ticket System</h3>
            <div class="form-group">
                <i class="fa fa-user-circle-o icon fa-lg"></i>
                <input type="text" class="form-control" name="posted_username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <i class="fa fa-lock icon fa-lg"></i>
                <input type="password" class="form-control" name="posted_password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" name="post_login">Login</button>
            </div>
                <a href="#" class="btn btn-info btn-block" role="button">Forgot Password?</a>
        </form>
    </div>

</body>

</html>