<?php

    session_start();
    require_once('functions.php');

    // Make sure only people logged in AND IT Support managers can view this page
    onlyAdminAccess();

    require('classes/Ticket.php');

    $id = @$_GET['id'];
    
    $viewTicket = new Ticket();
    $viewCon = $viewTicket->connect();
    $findTicket = $viewTicket->getTicket($viewCon, $id);
    $prevComments = $viewTicket->getComments($viewCon, $id);

    // View the ticket details
    if ($findTicket != NULL) {
        $ticketInfo = mysqli_fetch_assoc($findTicket);
    } else {
        // This SHOULDN'T be possible
        echo '<script type="text/javascript">alert("HOW DID YOU SELECT A TICKET THAT DOES NOT EXIST????");</script>';
        header("refresh:0; url=login.php");
        exit();
    }

    // Re-assign the pending ticket to another IT Support user
    if (isset($_POST['submit'])) {

        $ticketID = $_POST['ticketID'];
        $agent =$_POST['supportReps'];

        // Attempt to assign the IT Support user to the ticket
        if ($check = $viewTicket->assignRep($viewCon, $agent, $ticketID)) {

            // User was assigned to the ticket
            $msg = "Ticket updated successfully";
            echo '<script type="text/javascript">alert("'.$msg.'");</script>';
            $viewCon->close();
            header("refresh:0; url=open_tickets.php");
        } else {

            // The ticket couldn't be updated in the DB
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $viewCon->close();
            header("refresh:0; url=index.php");
        }
    }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <form method="post" action="view_pending_ticket.php" role="form">
        <div class="modal-body">
            <div class="form-group">
                <label for="ticketID">Ticket ID</label>
                <input type="text" class="form-control" id="ticketID" name="ticketID" value="<?php echo $ticketInfo['ticket_id'];?>" readonly="true"/>
            </div>
            <div class="form-group">
                <label for="createdBy">Created by</label>
                <input type="text" class="form-control" id="createdBy" name="createdBy" value="<?php echo $ticketInfo['username'];?>" readonly="true"/>
            </div>
            <div class="form-group">
                <label for="createDate">Submitted</label>
                <input type="text" class="form-control" id="createDate" name="createDate" value="<?php echo $ticketInfo['date_created'];?>" readonly="true"/>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <input type="text" class="form-control" id="priority" name="priority" value="<?php echo $ticketInfo['priority'];?>" readonly="true"/>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $ticketInfo['title'];?>" readonly="true"/>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" rows="5" id="description" readonly="true"><?php echo $ticketInfo['description'];?></textarea>
            </div>
            <?php

                $scrollingText = "";

                // Only display the "Previous comments" text area if there are actually previous comments for the ticket
                if ($prevComments != NULL && $prevComments->num_rows > 0) {

                    // Display all previous comments associated with the ticket
                    while ($commentDetails = mysqli_fetch_assoc($prevComments)) {

                        $scrollingText .= "_______________________\n";
                        $scrollingText .= $commentDetails['time_stamp'] . "\n";
                        $scrollingText .= $commentDetails['username'] . "\n\n";
                        $scrollingText .= $commentDetails['comment'] . "\n\n\n";
                    }

                    echo '<div class="form-group">';
                        echo '<label for="prevComments">Previous Comments</label>';
                        echo '<textarea class="form-control" rows="8" id="prevComments" readonly="true">'.$scrollingText.'</textarea>';
                    echo '</div>';
                }

                require('classes/User.php');
                $user = new User();
                $availAgents = $user->getITReps($viewCon);
                if ($availAgents != NULL) {
                    echo '<div class="form-group">';
                    echo '<label for="supportReps">Select IT Support user to assign:</label>';
                    echo '<select class="custom-select" name="supportReps" id="supportReps" required>';
                        echo '<option value="">Choose...</option>';
                        while($reps = mysqli_fetch_assoc($availAgents)) {
                            echo '<option value="'.$reps['username'].'">'.$reps['username'].'</option>';
                        }
                        echo '</select>';
                    echo '</div>';
                }
                
            ?>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-info" name="submit">Assign</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </form>

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>