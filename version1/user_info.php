<?php

    /*
     * This page will display the user's information as it is stored in the 
     * users table in MySQL. If the user needs to have some of their information
     * updated (they were promoted or moved to a different department), they
     * would need to submit a ticket.
     * 
     * If the user wants to change their password, they can do so on their own 
     * from this page.
    */
    
    include('connection.php');

    session_start();

    // Make sure that the user is not in the "IT Supoort" deparment
    if($_SESSION['Department'] == "IT Support") {
      header("Location: index.php");
      session_destroy();
  } 
    
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>User "User Info" Page</title>    
  <link href="style.css" rel="stylesheet">

  <style>
  .button {
    background-color: #b3edff;
    border: 2px solid black;
    border-radius: 4px;
    color: black;
    padding: 15px 32px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
  }
  </style>
</head>
<body>

<div class="sidenav">
    <a href="user_main.php">Home</a>
    <a href="user_create_ticket.php">Create New Ticket</a>
    <a href="user_tickets.php">View Tickets</a>
    <a href="user_info.php">User Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
<h1>User Information</h1>
<br>
<h3>If you need to update your contact information, please submit a ticket.</h3><br>
<p style="font-weight: normal;">User ID:  <?php echo $_SESSION['User_ID'];?></p>
<p style="font-weight: normal;">Full Name:  <?php echo $_SESSION['First_Name'].' '.$_SESSION['Last_Name'];?></p>
<p style="font-weight: normal;">Email:  <?php echo $_SESSION['Email'];?></p>
<p style="font-weight: normal;">Phone Number:  <?php echo $_SESSION['Phone_Num'];?></p>
<p style="font-weight: normal;">Department:  <?php echo $_SESSION['Department'];?></p>
<p style="font-weight: normal;">Position:  <?php echo $_SESSION['Position'];?></p>
<br><br>
<p style="font-weight: bold;">Need to update/change your password?</p><br>
<a href="change_password.php" class="button">Change Password</a>
</a>  
</div>

</body>
</html>