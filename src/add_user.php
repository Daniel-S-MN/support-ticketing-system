<?php
    
    include('connection.php');

    session_start();

    $UserID = mysqli_real_escape_string($con, $_REQUEST['userID']);
    $psw = mysqli_real_escape_string($con, $_REQUEST['tempPswrd']);
    $firstName = mysqli_real_escape_string($con, $_REQUEST['firstName']);
    $lastName = mysqli_real_escape_string($con, $_REQUEST['lastName']);
    $userEmail = mysqli_real_escape_string($con, $_REQUEST['userEmail']);
    $userPhone = mysqli_real_escape_string($con, $_REQUEST['phoneNum']);
    $userDept = mysqli_real_escape_string($con, $_REQUEST['userDept']);
    $userPos = mysqli_real_escape_string($con, $_REQUEST['userPost']);

    $sql = "INSERT INTO users (user_id, password, first_name, last_name, email, phone_number, department, position)
        VALUES ('$UserID', md5('$psw'), '$firstName', '$lastName', '$userEmail', '$userPhone', '$userDept', '$userPos')";
    
    if(mysqli_query($con, $sql)) {
        // New user was successfully added to the DB
        echo '<script>alert("New user successfully created")</script>';
        header("refresh:0; url=system_users.php");
    } else {
        // Failure is always an option, I guess
        echo '<script>alert("ERROR: Unable to execute $sql. " . mysqli_error($con))</script>';
        header("refresh:0; url=system_users.php");
    }
?>