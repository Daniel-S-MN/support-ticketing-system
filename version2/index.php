<?php

// Just testing to see if I can even get going with using classes for version 2 of the prototype

session_start();

if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes")
{
	header("Location: login.php");
	exit();
}

?>

<html>
 <head>
  <title>Version 2 Index</title>
 </head>
 <body>
  <?php echo'<p>This page should only be visible after logging in.</p>';?>
  <br><br>
  <button type=“button”><a href="logout.php">Log Out</a></button>
 </body>
</html>