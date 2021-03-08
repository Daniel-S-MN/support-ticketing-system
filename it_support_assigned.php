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
 
  <title>IT Suppor User "Tickets Assigned To Me" Page</title>    
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
<h3>This is the testing "view tickets assigned to me" page for the IT Support users.</h3>
<br>

<?php

  $username = $_SESSION['User_ID'];

  $query = "SELECT ticket_id, date_created, priority, created_by, description, status 
    FROM tickets WHERE assigned_to = '$username' ";

  $result = mysqli_query($con, $query) or die("Error processing query. ".mysql_error());

  echo "<table border='2' cellpadding='2' cellspacing='2'>";
    echo "<tr bgcolor='#b3edff'>";
      echo "<th>Ticket ID</th>";
      echo "<th>Date Created</th>";
      echo "<th>Priority</th>";
      echo "<th>Created By</th>";
      echo "<th>Description</th>";
      echo "<th>Status</th>";
    echo "</tr>";

  while($ticket = mysqli_fetch_object($result)) {

    echo "<tr>";
    echo "<td align='center'>$ticket->ticket_id</td>";
    echo "<td align='center'>$ticket->date_created</td>";
    echo "<td align='center'>$ticket->priority</td>";
    echo "<td align='center'>$ticket->created_by</td>";
    echo "<td>$ticket->description</td>";
    echo "<td align='center'>$ticket->status</td>";
    echo "</tr>";
  }

  echo "</table>";

?>

</div>
</body>
</html>