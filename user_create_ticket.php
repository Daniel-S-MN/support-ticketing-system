<?php

    /*
     * This page allows a user to submit a new ticket. The only fields that the
     * user needs to enter are the priority of the ticket and the ticket description.
     * All the other fields required for the tickets table are either auto generated
     * in MySQL or are added through insert.php
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
 
  <title>User "Create Ticket" Page</title>    
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
    <h3>This is the testing "create ticket" page for the non-IT users.</h3>
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