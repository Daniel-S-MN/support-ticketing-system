<?php
    
  include('connection.php');

  session_start();

  // Make sure the user is part of the "IT Support" department
  if($_SESSION['Department'] != "IT Support") {
    header("Location: index.php");
    session_destroy();
  } 

  if(isset($_POST['assign'])) {
    // Assign the ticket to the IT Support user that is logged in
    $user = $_SESSION['User_ID'];
    $ticketID = $_POST['id'];
    $sql = "UPDATE `tickets` SET `assigned_to` = '$user', `status` = 'Pending' 
      WHERE `tickets`.`ticket_id` = $ticketID";

    if(mysqli_query($con, $sql)) {
      /*
       * Ideally, the user will receive a pop-up that the ticket was successfully created
       * and THEN be re-directed to the user main page. I would also prefer to have this 
       * be where a confirmation email is sent, but I don't have dummy emails ready to go.
      */
      header("Location: it_support_assigned.php");
    
    } else {

      echo "ERROR: Unable to execute $sql. " . mysqli_error($con);
    }
      
  }  

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>IT Support "View Unassigned Open Tickets" Page</title>    
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
<h3>This is the testing "view all open unassigned tickets" page for the IT Support users.</h3>
<br>

<?php

  /*
   * This is just a temporary workaround to be able to assign an open ticket to the IT Support
   * user. In the next iteration, I'll be integrating BootStrap, which will work MUCH more 
   * smoothly for interacting with the tickets table in the DB.
   * 
   * Source:
   * https://www.daniweb.com/programming/web-development/threads/331121/use-radio-button-to-select-row-of-returned-query-data
  */

  $query = "SELECT ticket_id, date_created, priority, created_by, description, status FROM 
    tickets WHERE assigned_to IS NULL ";

  $result = mysqli_query($con, $query) or die("Error processing query. ".mysql_error());

  echo "<form method='post'>";
  echo "<table border='2' cellpadding='2' cellspacing='2'>";
    echo "<tr bgcolor='#b3edff'>";
      echo "<th>Select</th>";
      echo "<th>Ticket ID</th>";
      echo "<th>Date Created</th>";
      echo "<th>Priority</th>";
      echo "<th>Created By</th>";
      echo "<th>Description</th>";
      echo "<th>Status</th>";
    echo "</tr>";

  while($ticket = mysqli_fetch_object($result)) {

    echo "<tr>";
    echo "<td><input type='radio' name='id' value='".$ticket->ticket_id."' required></td>";
    echo "<td align='center'>$ticket->ticket_id</td>";
    echo "<td align='center'>$ticket->date_created</td>";
    echo "<td align='center'>$ticket->priority</td>";
    echo "<td align='center'>$ticket->created_by</td>";
    echo "<td>$ticket->description</td>";
    echo "<td align='center'>$ticket->status</td>";
    echo "</tr>";
  }

  echo "</table><br><br>";
  echo "<input type = 'submit' name = 'assign' value = 'Assign Ticket'><br><br>";
  echo "</form>";

?>

</div>
</body>
</html>