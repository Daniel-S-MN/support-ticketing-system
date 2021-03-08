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
 
  <title>IT Support Manager "Create Ticket" Page</title>    
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
    <h3>This is the testing "create ticket" page for the IT Support Manager users.</h3>
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