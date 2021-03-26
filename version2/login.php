<?php

if (isset($_POST['post_login'])) {

    require('classes/User.php');

    $user = new User();
    $user->connect();

    if($user->login($_POST['posted_username'], $_POST['posted_password'])) {
        // Send the user to the correct main page, based on department and/or position
        header("Location: index.php");
    } else {
        $errormsg = $user->getError();
        //echo '<script>alert("${errormsg}")</script>';
        echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        header("refresh:0; url=index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>

<div id="login">

    <form method="post">

        <div style="font-size: 20px; margin: 10px; color: white;">Suppor Ticket System</div>
        <br>
        <input id="loginText" type="text" name="posted_username" placeholder="Enter your user ID" required><br><br>
        <input id="loginText" type="password" name="posted_password" placeholder="Enter your password" required><br><br>

        <input id="loginButton" type="submit" name="post_login" value="Login"><br><br>

    </form>

</div>

</body>
</html>