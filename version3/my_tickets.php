<?php

session_start();
require_once('functions.php');

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
            
            <h2>My Tickets</h2><hr>

            <?php
        
                require('classes/Ticket.php');

                $ticket = new Ticket();

                $con = $ticket->connect();

                $myOpenTickets = $ticket->getMyOpenTickets($con, $_SESSION['Username']);

                if ($myOpenTickets != NULL) {

                    // Display all the user's open/pending tickets in a table
                    echo "<h4>Open/Pending Tickets:</h4><br>";
                    echo "<table class='table table-hover table-bordered'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Ticket ID</th>";
                            // echo "<th>Date Created</th>";
                            echo "<th>Priority</th>";
                            echo "<th>Title</th>";
                            // echo "<th>Assigned To</th>";
                            // echo "<th>Status</th>";
                            echo "<th>Details</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while($ticketInfo = mysqli_fetch_assoc($myOpenTickets)) {

                        echo '<tr>';
                            echo '<td>'.$ticketInfo['ticket_id'].'</td>';
                            // echo '<td>'.$ticketInfo['date_created'].'</td>';
                            echo '<td>'.$ticketInfo['priority'].'</td>';
                            echo '<td>'.$ticketInfo['title'].'</td>';
                            // echo '<td>'.$ticketInfo['assigned_to'].'</td>';
                            // echo '<td>'.$ticketInfo['status'].'</td>';
                            echo '<td><a class="btn btn-info" data-toggle="modal" data-target="#ticketInfo" 
                                data-whatever="'.$ticketInfo['ticket_id'].'">View</a></td>';
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

                $myClosedTickets = $ticket->getMyClosedTickets($con, $_SESSION['Username']);

                if ($myClosedTickets != NULL) {

                    // Display all the user's closed tickets in a table
                    echo "<br><h4>Closed Tickets:</h4><br>";
                    echo "<table class='table table-hover table-bordered'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Ticket ID</th>";
                            // echo "<th>Date Created</th>";
                            echo "<th>Priority</th>";
                            echo "<th>Title</th>";
                            // echo "<th>Assigned To</th>";
                            // echo "<th>Status</th>";
                            echo "<th>Details</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while($closedInfo = mysqli_fetch_assoc($myClosedTickets)) {

                        echo '<tr>';
                            echo '<td>'.$closedInfo['ticket_id'].'</td>';
                            // echo '<td>'.$closedInfo['date_created'].'</td>';
                            echo '<td>'.$closedInfo['priority'].'</td>';
                            echo '<td>'.$closedInfo['title'].'</td>';
                            // echo '<td>'.$closedInfo['assigned_to'].'</td>';
                            // echo '<td>'.$closedInfo['status'].'</td>';
                            echo '<td><a class="btn btn-info" data-toggle="modal" data-target="#ticketInfo" 
                                data-whatever="'.$closedInfo['ticket_id'].'">View</a></td>';
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

            <!-- ticketInfo modal -->
            <div class="modal fade bd-example-modal-lg" id="ticketInfo" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="userModalLabel">Ticket Details</h4>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        </div>
                        <div class="populateData">

                        </div>

                    </div>
                </div>
            </div> <!-- end of ticket info -->

                
        </div> <!-- End of content -->
    </div> <!-- End of wrapper -->

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#ticketInfo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this);
            var dataString = 'id=' + recipient;

                $.ajax({
                    type: "GET",
                    url: "view_my_ticket.php",
                    data: dataString,
                    cache: false,
                    success: function (data) {
                        console.log(data);
                        modal.find('.populateData').html(data);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
        })
    </script>
    
 </body>
</html>