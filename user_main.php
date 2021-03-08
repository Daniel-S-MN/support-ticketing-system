<?php
    
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
 
  <title>User Main Page</title>    
  <link href="style.css" rel="stylesheet">
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
<h3>This is the testing main page for the non-IT users.</h3>
<div>
<?php
  echo 'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!';
?>
</div>

</body>
</html>