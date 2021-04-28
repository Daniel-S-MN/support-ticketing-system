<?php

session_start();
require_once('functions.php');

// Make sure only people logged in AND IT Support managers can view this page
onlyAdminAccess();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <title>System Users</title>    
  
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
                <?php showITManagerMenu(); ?>
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
            
            <h2>System Users</h2><hr>
            <!-- Display all the users currently in the DB -->
            <?php

                require('classes/User.php');

                $user = new User();

                $con = $user->connect();

                $sysUsers = $user->getAllUsers($con);

                if ($sysUsers != NULL) {

                    // Display all the system users in a table
                    echo "<h4>Here are all of the users in the system:</h4><br>";
                    echo "<table class='table table-hover table-bordered'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Username</th>";
                            echo "<th>First Name</th>";
                            echo "<th>Last Name</th>";
                            echo "<th>Email</th>";
                            echo "<th>Phone #</th>";
                            echo "<th>Department</th>";
                            echo "<th>Title</th>";
                            echo "<th></th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while($systemUsers = mysqli_fetch_assoc($sysUsers)) {
                        echo '<tr>';
                            echo '<td>'.$systemUsers['username'].'</td>';
                            echo '<td>'.$systemUsers['f_name'].'</td>';
                            echo '<td>'.$systemUsers['l_name'].'</td>';
                            echo '<td>'.$systemUsers['email'].'</td>';
                            echo '<td>'.$systemUsers['phone_num'].'</td>';
                            echo '<td>'.$systemUsers['department'].'</td>';
                            echo '<td>'.$systemUsers['title'].'</td>';
                            echo '<td><a class="btn btn-info" data-toggle="modal" data-target="#getUserInfo" 
                                data-whatever="'.$systemUsers['username'].'">Edit</a></td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';

                } else {
                    // There was an issue with the mysql query
                    $errormsg = $user->getError();
                    echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
                    $con->close();
                    header("refresh:0; url=index.php");
                }
                            
            ?>

            <!-- Modal -->
            <div class="modal fade" id="getUserInfo" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="userModalLabel">Edit User Information</h4>
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        </div>
                        <div class="populateData">

                        </div>

                    </div>
                </div>
            </div> <!-- End of modal -->

        </div> <!-- End of content -->
    </div> <!-- End of wrapper -->

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#getUserInfo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('whatever') // Extract info from data-* attributes
            var modal = $(this);
            var dataString = 'id=' + recipient;

                $.ajax({
                    type: "GET",
                    url: "edit_users.php",
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