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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css">
  
  <style>
      h3{color:white;}
      body {
        background-image: url('./images/Metropolitan_State_University_New_Main_V2.jpg');
        background-repeat: no-repeat;
        background-size: auto;
        background-position: center center;
        padding-top: 25vh;
      }
  </style>
</head>

<body>
    
    <form class="login" method="post">
        <h3>Support Ticket System</h3><br>
        
        <div class="loginInput">
            <i class="fa fa-user-circle-o icon fa-lg"></i>
            <input class="testField" type="text" name="posted_username" placeholder="Username" required>
        </div>
            
        <div class="loginInput">
            <i class="fa fa-lock icon fa-lg"></i>
            <input class="testField" type="password" name="posted_password" placeholder="Password" required>
        </div>
        
        <input class="loginButton" type="submit" name="post_login" value="Login" style="cursor:pointer"><br>
            
    </form>


</body>

</html>