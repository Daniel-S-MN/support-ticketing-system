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
 
  <title>IT Support (non-manager) Main Page</title>    
  <link href="style.css" rel="stylesheet">
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
<h3>This is the testing main page for the IT Support non-manager users.</h3>
<div>
<?php
  echo 'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!';
?>
</div>

</body>
</html>