<?php
    // Login form example found:
    // https://epicbootstrap.com/snippets/login-form-dark

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
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Untitled</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/login_prompt.css">
</head>

<body>
    <div class="login-dark">
        <form method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-locked"></i></div>
            <div class="form-group"><input class="form-control" type="text" name="posted_username" placeholder="User ID"></div>
            <div class="form-group"><input class="form-control" type="password" name="posted_password" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button></div><a href="#" class="forgot">Forgot your email or password?</a></form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>