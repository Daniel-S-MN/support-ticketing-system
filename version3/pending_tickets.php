<?php

session_start();

// Make sure only people logged in AND IT Support managers can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Access'] != 3) {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>Pending Tickets</title>    
  
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/stylesheet.css">

    <!-- For whatever reason, formatting only works if I include here, rather than the CSS file... -->
    <style>
        .table td, th {
            text-align: center;
            vertical-align: middle;
        }
    </style>  

</head>
  <body>

    <div class="wrapper">
        <!-- The sidebar and navigation links -->
        <nav id="desktopNav">
            <ul class="list-unstyled components">
                <li><a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                <li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>
                    <ul class="collapse list-unstyled" id="troubleshooting">
                        <li><a href="open_tickets.php">Open Tickets</a></li>
                        <li><a href="pending_tickets.php">Pending Tickets</a></li>
                        <li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>
                    </ul>
                </li>
                <li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>
                <li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>
                <li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>
                <li><a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users" aria-hidden="true"></i> System Users</a>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li><a href="system_users.php">View/Edit Users</a></li>
                        <li><a href="new_user.php">Create New User</a></li>
                    </ul>
                </li>
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
            
            <h2>Pending Tickets</h2><hr>
            <h4>Tickets currently assigned to an IT Support rep:</h4><br>
            <!-- Display the tickets that are assigned to other IT Support users -->
            <?php
            
                require('classes/Ticket.php');
                require('classes/User.php');
        
                $ticket = new Ticket();
        
                $con = $ticket->connect();
        
                $user = new User();
        
                $pendingTickets = $ticket->getAllPendingTickets($con);
        
                if ($pendingTickets != NULL) {

                    echo "<table class='table table-hover table-bordered'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Ticket ID</th>";
                            echo "<th>Date Created</th>";
                            echo "<th>Priority</th>";
                            echo "<th>Created By</th>";
                            echo "<th>Title</th>";
                            echo "<th>Assigned To</th>";
                            echo "<th>Details</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while($tickets = mysqli_fetch_assoc($pendingTickets)) {

                        echo '<tr>';
                            echo '<td>'.$tickets['ticket_id'].'</td>';
                            echo '<td>'.$tickets['date_created'].'</td>';
                            echo '<td>'.$tickets['priority'].'</td>';
                            echo '<td>'.$tickets['username'].'</td>';
                            echo '<td>'.$tickets['title'].'</td>';
                            echo '<td>'.$tickets['assigned_to'].'</td>';
                            echo '<td><a class="btn btn-info" data-toggle="modal" data-target="#ticketInfo" 
                                data-whatever="'.$tickets['ticket_id'].'">View</a></td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    
                } else {
                    // There was an issue with the mysql query
                    $errormsg = $ticket->getError();
                    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
                    $con->close();
                    header("refresh:0; url=index.php");
                }
            
            ?>

            <!--
                Here is where I found how to make a bootstrap table row "clickable":
                https://www.jasny.net/bootstrap/components/#rowlink
            -->

            <div id="ticketInfo" class="modal" role="dialog" aria-labelledby="ticketInfoTitle" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100" id="ticketInfoTitle">Ticket Details and Troubleshooting</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>This is where the ticket information will be displayed.</p>
                        <p>It is also where the IT Support manager can re-assign the ticket to another IT Support user.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-info">Re-assign</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
 </body>
</html>