<?php

session_start();

// Make sure only people logged in can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>View My Tickets</title>    
  
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
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
                    if ($_SESSION['Access'] == 1) {
                        // Non-IT Support users
                        echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
                        echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
                        echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';

                    } elseif ($_SESSION['Access'] == 2) {
                        // IT Support non-managers
                        echo '<li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>';
                            echo '<ul class="collapse list-unstyled" id="troubleshooting">';
                                echo '<li><a href="open_tickets.php">Open Tickets</a></li>';
                                echo '<li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>';
                            echo '</ul>';
                        echo '</li>';
                        echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
                        echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
                        echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';

                    } elseif ($_SESSION['Access'] == 3) {
                        // IT Support managers (admin)
                        echo '<li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>';
                            echo '<ul class="collapse list-unstyled" id="troubleshooting">';
                                echo '<li><a href="open_tickets.php">Open Tickets</a></li>';
                                echo '<li><a href="pending_tickets.php">Pending Tickets</a></li>';
                                echo '<li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>';
                            echo '</ul>';
                        echo '</li>';
                        echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
                        echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
                        echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';
                        echo '<li>';
                            echo '<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users" aria-hidden="true"></i> System Users</a>';
                            echo '<ul class="collapse list-unstyled" id="pageSubmenu">';
                                echo '<li><a href="system_users.php">View/Edit Users</a></li>';
                                echo '<li><a href="new_user.php">Create New User</a></li>';
                            echo '</ul>';
                        echo '</li>';
                    }

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
            
            <h2>My Tickets</h2><hr>

            <?php
        
                require('classes/Ticket.php');

                $ticket = new Ticket();

                $con = $ticket->connect();

                $myOpenTickets = $ticket->getMyOpenTickets($con, $_SESSION['Username']);

                if ($myOpenTickets != NULL) {

                    // I want to place the table CSS formatting in the CSS file, but it won't work,
                    // so I'm just going to keep it here.
                    echo "<style>";
                    echo ".table td, th{";
                        echo "text-align:center;";
                        echo "vertical-align: middle;";
                        echo "}";
                    echo "</style>";

                    // Display all the user's open/pending tickets in a table
                    echo "<h4>Open/Pending Tickets:</h4><br>";
                    echo "<table class='table table-hover table-bordered'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Ticket ID</th>";
                            echo "<th>Date Created</th>";
                            echo "<th>Priority</th>";
                            echo "<th>Title</th>";
                            echo "<th>Description</th>";
                            echo "<th>Assigned To</th>";
                            echo "<th>Status</th>";
                            echo "<th></th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($ticketInfo = mysqli_fetch_object($myOpenTickets)) {
                        echo "<tr>";
                            echo "<td>$ticketInfo->ticket_id</td>";
                            echo "<td>$ticketInfo->date_created</td>";
                            echo "<td>$ticketInfo->priority</td>";
                            echo "<td>$ticketInfo->title</td>";
                            echo "<td>$ticketInfo->description</td>";
                            echo "<td>$ticketInfo->assigned_to</td>";
                            echo "<td>$ticketInfo->status</td>";
                            echo "<td><button type='button' class='btn btn-info'>Edit</button></td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";

                } else {
                    // There was an issue with the mysql query
                    $errormsg = $ticket->getError();
                    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
                    $con->close();
                    header("refresh:0; url=index.php");
                }

                $myClosedTickets = $ticket->getMyClosedTickets($con, $_SESSION['Username']);

                if ($myClosedTickets != NULL) {

                    // Display all the user's closed tickets in a table
                    echo "<br><h4>Closed Tickets:</h4><br>";
                    echo "<table class='table table-hover table-bordered'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th scope='col'>Ticket ID</th>";
                            echo "<th scope='col'>Date Created</th>";
                            echo "<th scope='col'>Priority</th>";
                            echo "<th scope='col'>Title</th>";
                            echo "<th scope='col'>Description</th>";
                            echo "<th scope='col'>Assigned To</th>";
                            echo "<th scope='col'>Status</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while($ticketInfo = mysqli_fetch_object($myClosedTickets)) {
                        echo "<tr>";
                            echo "<th scope='row'>$closedInfo->ticket_id</td>";
                            echo "<td>$closedInfo->date_created</td>";
                            echo "<td>$closedInfo->priority</td>";
                            echo "<td>$closedInfo->title</td>";
                            echo "<td>$closedInfo->description</td>";
                            echo "<td>$closedInfo->assigned_to</td>";
                            echo "<td>$closedInfo->status</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                    
                } else {
                    // There was an issue with the mysql query
                    $errormsg = $ticket->getError();
                    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
                    $con->close();
                    header("refresh:0; url=index.php");
                }
        
        ?>

                
        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 </body>
</html>

<!--
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>My Tickets</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        /*
        // Some menu items are only displayed based on the user permissions level
        if ($_SESSION['Access'] == 1) {
            // Non-IT Support users
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } elseif ($_SESSION['Access'] == 2) {
            // IT Support non-managers
            echo '<a href="open_tickets.php">Open Tickets</a>';
            echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } elseif ($_SESSION['Access'] == 3) {
            // IT Support Managers (admins)
            echo '<a href="open_tickets.php">Open Tickets</a>';
            echo '<a href="pending_tickets.php">Pending Tickets</a>';
            echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
            echo '<a href="system_users.php">System Users</a>';
            echo '<a href="new_user.php">New User</a>';
        }

        ?>

        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <br><h4>This is where you can view your tickets.</h4><br>
        <div>

        <?php
        
        require('classes/Ticket.php');

        $ticket = new Ticket();

        $con = $ticket->connect();

        $myOpenTickets = $ticket->getMyOpenTickets($con, $_SESSION['Username']);

        if ($myOpenTickets != NULL) {

            echo "<style>";
            echo ".tablecenterheadCSS th, td{";
                echo "text-align:center;";
                echo "vertical-align: middle;";
                echo "}";
            echo "</style>";

            // Display all the user's open/pending tickets in a table
            echo "<h4>My Open/Pending Tickets:</h4>";
            echo "<table class='tablecenterheadCSS table table-hover table-bordered'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'>Ticket ID</th>";
                    echo "<th scope='col'>Date Created</th>";
                    echo "<th scope='col'>Priority</th>";
                    echo "<th scope='col'>Title</th>";
                    echo "<th scope='col'>Description</th>";
                    echo "<th scope='col'>Assigned To</th>";
                    echo "<th scope='col'>Status</th>";
                    echo "<th scope='col'>Edit</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($ticketInfo = mysqli_fetch_object($myOpenTickets)) {
                echo "<tr>";
                    echo "<th scope='row'>$ticketInfo->ticket_id</td>";
                    echo "<td>$ticketInfo->date_created</td>";
                    echo "<td>$ticketInfo->priority</td>";
                    echo "<td>$ticketInfo->title</td>";
                    echo "<td>$ticketInfo->description</td>";
                    echo "<td>$ticketInfo->assigned_to</td>";
                    echo "<td>$ticketInfo->status</td>";
                    echo "<td><button type='button' class='btn btn-primary'>Edit</button></td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";

        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }

        $myClosedTickets = $ticket->getMyClosedTickets($con, $_SESSION['Username']);

        if ($myClosedTickets != NULL) {

            // Display all the user's closed tickets in a table
            echo "<br><h4>My Closed Tickets:</h4>";
            echo "<table class='tablecenterheadCSS table table-hover table-bordered'>";
            echo "<thead>";
                echo "<tr>";
                    echo "<th scope='col'>Ticket ID</th>";
                    echo "<th scope='col'>Date Created</th>";
                    echo "<th scope='col'>Priority</th>";
                    echo "<th scope='col'>Title</th>";
                    echo "<th scope='col'>Description</th>";
                    echo "<th scope='col'>Assigned To</th>";
                    echo "<th scope='col'>Status</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($ticketInfo = mysqli_fetch_object($myClosedTickets)) {
                echo "<tr>";
                    echo "<th scope='row'>$closedInfo->ticket_id</td>";
                    echo "<td>$closedInfo->date_created</td>";
                    echo "<td>$closedInfo->priority</td>";
                    echo "<td>$closedInfo->title</td>";
                    echo "<td>$closedInfo->description</td>";
                    echo "<td>$closedInfo->assigned_to</td>";
                    echo "<td>$closedInfo->status</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            
        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }
        */
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
 </body>
</html>
-->