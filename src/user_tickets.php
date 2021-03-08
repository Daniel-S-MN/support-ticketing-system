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
 
  <title>User "View Tickets" Page</title>    
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
<h3>This is the testing "view tickets" page for the non-IT users.</h3>
<br>

<?php
  $username = $_SESSION['User_ID'];

  $query = "SELECT ticket_id, date_created, priority, description, assigned_to, status 
    FROM tickets WHERE created_by = '$username' ";

  $result = mysqli_query($con, $query) or die("Error processing query. ".mysql_error());

  echo "<table border='2' cellpadding='2' cellspacing='2'>";
    echo "<tr bgcolor='#b3edff'>";
      echo "<th>Ticket ID</th>";
      echo "<th>Date Created</th>";
      echo "<th>Priority</th>";
      echo "<th>Description</th>";
      echo "<th>Assigned To</th>";
      echo "<th>Status</th>";
    echo "</tr>";

  while($ticket = mysqli_fetch_object($result)) {

    echo "<tr>";
    echo "<td align='center'>$ticket->ticket_id</td>";
    echo "<td align='center'>$ticket->date_created</td>";
    echo "<td align='center'>$ticket->priority</td>";
    echo "<td>$ticket->description</td>";
    echo "<td align='center'>$ticket->assigned_to</td>";
    echo "<td align='center'>$ticket->status</td>";
    echo "</tr>";
  }

  echo "</table>";

?>   
 
</div>

</body>
</html>