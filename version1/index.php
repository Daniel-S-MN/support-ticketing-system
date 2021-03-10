<?php

    include('connection.php');

    session_start();

    if(isset($_POST['post_login'])) {
        // Username and password from form
        $username = $_POST['posted_username'];
        $password = md5($_POST['posted_password']);

        $query = "SELECT * FROM users WHERE user_id = '$username' AND password = '$password'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        
        if(is_array($row)) {
            $_SESSION['User_ID'] = $row['user_id'];
            $_SESSION['First_Name'] = $row['first_name'];
            $_SESSION['Last_Name'] = $row['last_name'];
            $_SESSION['Email'] = $row['email'];
            $_SESSION['Phone_Num'] = $row['phone_number'];
            $_SESSION['Department'] = $row['department'];
            $_SESSION['Position'] = $row['position'];

            // Send the user to the correct main page, based on department and/or position
            header("Location: redirect.php");

        } else {
            echo '<script>alert("Invalid username or password")</script>';
            header("refresh:0; url=index.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<body>

<style type="text/css">

    #text {

        height: 25px;
        border-radius: 5px;
        padding: 4px;
        border: solid thin #aaa;
        width: 100%;

    }

    #button {

        padding: 10px;
        width: 100px;
        color: white;
        background-color: lightblue;
        border: none;

    }

    #box {

        margin: auto;
        border-radius: 20px;
        background-color: grey;
        padding: 20px;
        width: 300px;
        height: auto;
        text-align: center;
    }

</style>

<div id="box">

    <form method="post">

        <div style="font-size: 20px; margin: 10px; color: white;">Suppor Ticket System</div>
        <br>
        <input id="text" type="text" name="posted_username" placeholder="Enter your user ID" required><br><br>
        <input id="text" type="password" name="posted_password" placeholder="Enter your password" required><br><br>

        <input id="button" type="submit" name="post_login" value="Login"><br><br>

    </form>

</div>

</body>
</html>