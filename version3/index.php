<?php

session_start();

require_once('functions.php');

// Make sure only people logged in can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes")
{
	header("Location: login.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>Support Ticket System</title>    
  
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/stylesheet.css">
  
</head>
  <body>

    <div class="wrapper">
        <!-- The sidebar and navigation links -->
        <nav id="desktopNav">
            <ul class="list-unstyled components">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                <?php
                    // Some menu items are only displayed based on the user permissions level
                    if ($_SESSION['Access'] == 1) {showNonITMenu();
                    } elseif ($_SESSION['Access'] == 2) {showITSupportMenu();
                    } elseif ($_SESSION['Access'] == 3) {showITManagerMenu();}
                ?>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- 
            Here is the page content and mobile menu bar. The mobile bar is only visible when the screen
            size is smaller. The main navbar from above will not be displayed as well.
        -->
        <div id="content">

            <!-- Mobile navbar (this is only intended for non-IT Support users) -->
            <nav class="d-block d-md-none navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid">
                    <span class="navbar-brand mb-2 h1">Support Ticket System</span>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                                <li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>
                                <li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>
                                <li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                            </ul>
                        </div>
                </div>
            </nav>
                
            <!-- Welcome screen for all users and ticket stats for IT Support -->
            <?php
                echo "<h2>".'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!' . "</h2><hr>";
                echo "<div>";

                    require('classes/Ticket.php');

                    $ticket = new Ticket();

                    $con = $ticket->connect();

                    $numOpen = $ticket->getNumPendingTickets($con);
                    $numPend = $ticket->getNumWorkingTickets($con);
                    $numMine = $ticket->getNumOpenPendingTickets($con, $_SESSION['Username']);

                    echo "<h4>Here is a quick break-down of what's going on:</h4><br>";

                    echo '<div class="card-deck">';
                        // Display how many of the user's tickets are still open/pending
                        echo '<div class="card text-white text-center font-weight-bold bg-info mb-3" style="max-width: 20rem;">';
                        echo '<h4 class="card-header font-weight-bold">Your Open Tickets</h4>';
                        echo '<div class="card-body">';
                            echo '<h1 class="card-title font-weight-bold">'.$numMine.'</h1>';
                        echo '</div>';
                        echo '</div>';
                
                    if ($_SESSION['Access'] > 1) {
                        
                        // Display the number of open (unassigned) tickets are in the system
                        echo '<div class="card text-white text-center font-weight-bold bg-danger mb-3" style="max-width: 20rem;">';
                        echo '<h4 class="card-header font-weight-bold">System Open Tickets</h4>';
                        echo '<div class="card-body">';
                            echo '<h1 class="card-title font-weight-bold">'.$numOpen.'</h1>';
                        echo '</div>';
                        echo '</div>';

                        // Only managers need to see how many tickets are pending
                        if ($_SESSION['Access'] == 3) {

                            echo '<div class="card text-white text-center font-weight-bold bg-success mb-3" style="max-width: 20rem;">';
                            echo '<h4 class="card-header font-weight-bold">System Pending Tickets</h4>';
                            echo '<div class="card-body">';
                                echo '<h1 class="card-title font-weight-bold">'.$numPend.'</h1>';
                            echo '</div>';
                            echo '</div>';
                        }  
                    }
                    echo '</div>';
            ?>

        </div>
    </div>

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

 </body>
</html>