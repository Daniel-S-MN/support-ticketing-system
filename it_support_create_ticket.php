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
 
  <title>IT Support (non-manager) "Create Ticket" Page</title>    
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
    <h3>This is the testing "create ticket" page for the IT Support (non-manager) users.</h3>
    <h1>Submit a new ticket</h1>
    <form action="insert.php" method="post">
      <label for="levels">Select the ticket priority level: </label>
      <select name="levels" id="levels" required>
        <option value="">-Select-</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
      </select>
      <br><br>
      <p>High: needs to be resolved within 1 business day.</p>
      <p>Medium: needs to be resolved within 2-3 business days.</p>
      <p>Low: needs to be resolved within 4-7 business days.</p>
      <br>
      <label for="description">Ticket Description:</label><br>
      <textarea id="description" name="description" rows="10" cols="50" required></textarea>
      <br><br>
      <input type="submit" value="Submit New Ticket"/>
    </form>
</div>

</body>
</html>