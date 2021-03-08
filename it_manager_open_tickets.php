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
    } elseif($_SESSION['Position'] != "Manager") {

        header("Location: index.php");
        session_destroy();
    }

    /*
     * This assigns the ticket to the user selected from the drop-down after
     * the IT Support Manager first selects the ticket from the table containing
     * all the tickets in the DB that are listed as "Open" and do not currently
     * have anyone assigned to them.
    */
    if(isset($_POST['assign'])) {
      // A ticket was selected AND a user was selected
      $user = $_POST['it_users'];
      $ticketID = $_POST['id'];
      $sql = "UPDATE `tickets` SET `assigned_to` = '$user', `status` = 'Pending' WHERE `tickets`.`ticket_id` = $ticketID";
      
      if(mysqli_query($con, $sql)) {
        // Ticket was successfully updated
        header("refresh:0; url=it_manager_open_tickets.php");
      } else {
        // Ticket could not be updated
        echo '<script>alert("ERROR: Unable to execute MySQL query")</script>';
        header("refresh:0; url=it_manager_open_tickets.php");
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
    echo "<td align='center'><input type='radio' name='id' value='".$ticket->ticket_id."' required></td>";
    echo "<td align='center'>$ticket->ticket_id</td>";
    echo "<td align='center'>$ticket->date_created</td>";
    echo "<td align='center'>$ticket->priority</td>";
    echo "<td align='center'>$ticket->created_by</td>";
    echo "<td>$ticket->description</td>";
    echo "<td align='center'>$ticket->status</td>";
    echo "</tr>";
  }

  echo "</table><br><br>";
  //echo "<input type = 'submit' name = 'assign' value = 'Assign Ticket'><br><br>";

  // Find all the IT Support users
  $query2 = "SELECT user_id FROM users WHERE department='IT Support'";
  $result2 = mysqli_query($con, $query2) or die("Error processing query. ".mysql_error());

  echo "<label for='it_users'>Select IT Support user to assign ticket to: </label>";
  echo "<select name='it_users' id='it_users' required>";
  echo "<option value=''>-Select User-</option>";

  while($ticket2 = mysqli_fetch_object($result2)) {

    echo "<option value='".$ticket2->user_id."'>".$ticket2->user_id."</option>";
  }

  echo "</select><br><br>";
  echo "<input type='submit' name='assign' value='Assign Ticket'/>";
  echo "</form>";

?>

</div>
</body>
</html>