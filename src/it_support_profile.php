<?php
    
    include('connection.php');

    session_start();

    // Make sure the user is part of the "IT Support" department
    if($_SESSION['Department'] != "IT Support") {
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
 
  <title>IT Support "User Info" Page</title>    
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
    <a href="it_support_main.php">Home</a>
    <a href="it_support_assigned.php">My Tickets</a>
    <a href="unassigned_tickets.php">Open Tickets</a>
    <a href="it_support_create_ticket.php">Create Ticket</a>
    <a href="it_support_profile.php">User Profile</a>
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
<p style="font-weight: bold;">Need to update/change your password?</p>
<a href="change_password.php" class="button">Change Password</a>
</a>  
</div>

</body>
</html>