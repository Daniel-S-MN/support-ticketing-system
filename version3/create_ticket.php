<?php

session_start();

// Make sure only people logged in can view this page
if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
}

// Attempt to add the ticket to the DB
if (isset($_POST['submit_ticket'])) {

    require('classes/Ticket.php');

    $ticket = new Ticket();

    $con = $ticket->connect();

    $username = $_SESSION['Username'];

    $status = $ticket->newTicket($con, $username, $_POST['priority'], $_POST['title'], $_POST['description']);

    if ($status != 'Success') {
        // Ticket couldn't be added to the DB
        $errormsg = $ticket->getError();
        echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        $con->close();
        header("refresh:0; url=index.php");

    } else {
        // Ticket was added to the DB
        $msg = "Ticket was successfully submitted!";
        echo '<script type="text/javascript">alert("'.$msg.'");</script>';
        $con->close();
        header("refresh:0; url=my_tickets.php");
    }

}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>Create A New Ticket</title>    
  
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/testing.css">
  
</head>
  <body>

    <div class="wrapper">
        <!-- The sidebar and navigation links -->
        <nav id="sidebar">
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
            <nav class="d-block d-md-none navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <span class="navbar-brand mb-2 h1">Support Ticket System</span>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="create_ticket.php">Create Ticket</a></li>
                                <li class="nav-item"><a class="nav-link" href="my_tickets.php">My Tickets</a></li>
                                <li class="nav-item"><a class="nav-link" href="my_profile.php">My Profile</a></li>
                                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                </div>
            </nav>
            
            <h4>Create a new ticket</h4><br>

                <form method="post">
                <div class="form-group col-lg-6">
                    <label for="priority">Select ticket priority:</lable>
                    <select class="custom-select" name="priority" id="priority" required>
                        <option value="">Choose...</option>
                        <option value="High">High (within 1 business day)</option>
                        <option value="Medium">Medium (within 2-3 business days)</option>
                        <option value="Low">Low (within 4-7 business days)</option>
                        </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="title">Ticket Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required></textarea>
                </div>
                <div class="form-group col-lg-6">
                    <label for="description">Ticket description:</label>
                    <textarea class="form-control" id="description" rows="10" name="description" required></textarea>
                </div>
                <div class="col-auto">
                    <input type="submit" class="btn btn-info" name="submit_ticket" value="Submit New Ticket"/>
                </div>
                </form>
        </div>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

 </body>
</html>