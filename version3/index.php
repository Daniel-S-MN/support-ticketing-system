<?php

session_start();

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
  
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="styles/testing.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
</head>
  <body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>

                <?php

                // Some menu items are only displayed based on the user permissions level
                // if ($_SESSION['Access'] == 1) {
                //     // Non-IT Support users
                //     echo '<a href="create_ticket.php">Create Ticket</a>';
                //     echo '<a href="my_tickets.php">My Tickets</a>';
                //     echo '<a href="my_profile.php">My Profile</a>';
                // } elseif ($_SESSION['Access'] == 2) {
                //     // IT Support non-managers
                //     echo '<a href="open_tickets.php">Open Tickets</a>';
                //     echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
                //     echo '<a href="create_ticket.php">Create Ticket</a>';
                //     echo '<a href="my_tickets.php">My Tickets</a>';
                //     echo '<a href="my_profile.php">My Profile</a>';
                // } elseif ($_SESSION['Access'] == 3) {
                //     // IT Support Managers (admins)
                //     echo '<a href="open_tickets.php">Open Tickets</a>';
                //     echo '<a href="pending_tickets.php">Pending Tickets</a>';
                //     echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
                //     echo '<a href="create_ticket.php">Create Ticket</a>';
                //     echo '<a href="my_tickets.php">My Tickets</a>';
                //     echo '<a href="my_profile.php">My Profile</a>';
                //     echo '<a href="system_users.php">System Users</a>';
                //     echo '<a href="new_user.php">New User</a>';
                // }

                ?>

                <li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>
                    <ul class="collapse list-unstyled" id="troubleshooting">
                        <li><a href="#">Open Tickets</a></li>
                        <li><a href="#">Pending Tickets</a></li>
                        <li><a href="#">Tickets Assigned To Me</a></li>
                    </ul>
                </li>
                <li><a href="#"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>
                <li><a href="#"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users" aria-hidden="true"></i> System Users</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="#">View/Edit Users</a></li>
                        <li><a href="#">Create New User</a></li>
                    </ul>
                </li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

        <nav class="d-block d-md-none navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                <span class="navbar-brand mb-2 h1">Ticketing Support System</span>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Create Ticket</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">My Tickets</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">My Profile</a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <?php
                echo "<h3>".'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!' . "</h3>";
                echo "<hr>";
                echo "<div>";
                    if ($_SESSION['Access'] > 1) {

                    echo "<h4>Here is a quick break-down of what's going on:</h4><br>";

                    require('classes/Ticket.php');

                    $ticket = new Ticket();

                    $con = $ticket->connect();

                    $numOpen = $ticket->getNumPendingTickets($con);
                    $numPend = $ticket->getNumWorkingTickets($con);

                    echo "<h5>Number of open tickets: ".$numOpen."</h5><br>";
                    echo "<h5>Number of pending tickets: ".$numPend."</h5><br>";
                }
            ?>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <!--
    <div class="sidenav">
        <a href="index.php">Home</a>
        
        <?php

        // Some menu items are only displayed based on the user permissions level
        // if ($_SESSION['Access'] == 1) {
        //     // Non-IT Support users
        //     echo '<a href="create_ticket.php">Create Ticket</a>';
        //     echo '<a href="my_tickets.php">My Tickets</a>';
        //     echo '<a href="my_profile.php">My Profile</a>';
        // } elseif ($_SESSION['Access'] == 2) {
        //     // IT Support non-managers
        //     echo '<a href="open_tickets.php">Open Tickets</a>';
        //     echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
        //     echo '<a href="create_ticket.php">Create Ticket</a>';
        //     echo '<a href="my_tickets.php">My Tickets</a>';
        //     echo '<a href="my_profile.php">My Profile</a>';
        // } elseif ($_SESSION['Access'] == 3) {
        //     // IT Support Managers (admins)
        //     echo '<a href="open_tickets.php">Open Tickets</a>';
        //     echo '<a href="pending_tickets.php">Pending Tickets</a>';
        //     echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
        //     echo '<a href="create_ticket.php">Create Ticket</a>';
        //     echo '<a href="my_tickets.php">My Tickets</a>';
        //     echo '<a href="my_profile.php">My Profile</a>';
        //     echo '<a href="system_users.php">System Users</a>';
        //     echo '<a href="new_user.php">New User</a>';
        // }

        ?>

        <a href="logout.php">Logout</a>
    </div>

    <div class="main">

        <?php

            // echo "<h3>".'Hello, ' . $_SESSION['First_Name'] . ' ' . $_SESSION['Last_Name'] . '!' . "</h3>";
            // echo "<hr>";
            // echo "<div>";

            // if ($_SESSION['Access'] > 1) {

            //     echo "<h3>Here is a quick break-down of what's going on:</h3>";

            //     require('classes/Ticket.php');

            //     $ticket = new Ticket();

            //     $con = $ticket->connect();

            //     $numOpen = $ticket->getNumPendingTickets($con);
            //     $numPend = $ticket->getNumWorkingTickets($con);

            //     echo "<h3>Number of open tickets: ".$numOpen."</h3>";
            //     echo "<h3>Number of pending tickets: ".$numPend."</h3>";
            // }

        ?>

    </div>
    -->

 </body>
</html>