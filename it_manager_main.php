<?php
    
    include('connection.php');

    session_start();

    /*
     * I don't know why, but I'm only having success with comparisons in PHP if
     * I'm using != instead of == or ===. I don't know why it is, but it works 
     * for now.
     * 
     * This will make sure that only IT Support managers can view this page.
    */
    if($_SESSION['Department'] != "IT Support") {
        header("Location: index.php");
        session_destroy();
    }
    if($_SESSION['Position'] != "Manager") {
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
 
  <title>IT Support Manager Main Page</title>    
  <link href="style.css" rel="stylesheet">
</head>
<body>

<div class="sidenav">
    <a href="it_manager_main.php">Home</a>
    <a href="it_manager_tickets.php">My Tickets</a>
    <a href="it_manager_open_tickets.php">Open Tickets</a>
    <a href="pending_tickets.php">Pending Tickets</a>
    <a href="it_manager_create_ticket.php">Create Ticket</a>
    <a href="it_manager_profile.php">User Profile</a>
    <a href="system_users.php">System Users</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main">
<h3>This is the testing main page for the IT Support Manager users.</h3>
<div>
<?php
  echo 'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!';
?>
</div>

</body>
</html>