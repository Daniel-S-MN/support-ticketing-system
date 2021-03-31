<?php

session_start();

// Make sure only people logged in AND IT Support users can view this page

if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
	header("Location: login.php");
	exit();
} elseif ($_SESSION['Department'] != 'IT Support') {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
 
  <title>Assigned Tickets</title>    
  <link rel="stylesheet" href="styles/stylesheet.css" type="text/css" media="screen">
</head>
<body>
    
    <div class="sidenav">
        <a href="index.php">Home</a>

        <?php
        // Menu items will only display for the correct permissions of each user
        if ($_SESSION['Position'] != 'Manager') {
            // IT Support non-managers
            echo '<a href="open_tickets.php">Open Tickets</a>';
            echo '<a href="assigned_tickets.php">Assigned Tickets</a>';
            echo '<a href="create_ticket.php">Create Ticket</a>';
            echo '<a href="my_tickets.php">My Tickets</a>';
            echo '<a href="my_profile.php">My Profile</a>';
        } else {
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
        <h3>These tickets are assigned to you for troubleshooting:</h3>
        <hr><br>
        <div>

        <?php

        GLOBAL $ticketID;
        $ticketID = '';

        //require('classes/Database.php');
        require('classes/Ticket.php');

        //$db = new Database();

        //$con = $db->connect();

        $ticket = new Ticket();

        $con = $ticket->connect();

        $myID = $_SESSION['User_ID'];

        $myTickets = $ticket->getMyAssignedTickets($con, $myID);

        if ($myTickets != NULL) {

            echo'<form action="comment.php" method="post">';
            // echo '<form method="post">';
            echo '<table border="2" cellpadding="2" cellspacing="2">';
                echo '<tr bgcolor="#b3edff">';
                echo '<th>Select</th>';
                echo '<th>Ticket ID</th>';
                echo '<th>Date Created</th>';
                echo '<th>Priority</th>';
                echo '<th>Created By</th>';
                echo '<th>Description</th>';
                echo '<th>Status</th>';
                echo '</tr>';

            while($tickets = mysqli_fetch_object($myTickets)) {

                echo '<tr>';
                echo '<td align="center"><input type="radio" name="select_ticket" value="'.$tickets->ticket_id.'" required></td>';
                echo '<td align="center">'.$tickets->ticket_id.'</td>';
                echo '<td align="center">'.$tickets->date_created.'</td>';
                echo '<td align="center">'.$tickets->priority.'</td>';
                echo '<td align="center">'.$tickets->user_id.'</td>';
                echo '<td>'.$tickets->description.'</td>';
                echo '<td align="center">'.$tickets->status.'</td>';
                echo '</tr>';
            }

            // Select which ticket to troubleshoot
            echo '</table><br><hr><br>';
            // echo '<input type ="submit" name="troubleshoot" value ="Select Ticket"><br><br>';
            echo '<input type ="submit" value ="Select Ticket"><br><br>';
            echo '</form>';
            

        } else {
            // There was an issue with the mysql query
            $errormsg = $ticket->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $con->close();
            header("refresh:0; url=index.php");
        }

        // // A ticket was selected to add a comment to and/or close the ticket
        // if (isset($_POST['troubleshoot'])) {

        //     GLOBAL $ticketID;

        //     $ticketID = $_POST['select_ticket'];

        //     $previous = mysqli_fetch_object($ticket->getComments($con, $_POST['select_ticket']));

        //     $prevComms = $previous->comments;

        //     echo '<br><hr><p>Ticket ID: '. $_POST['select_ticket']  . '</p><hr><br>'; 

        //     echo '<label for="previous_comments">Previous Comments:</label><br>';
        //     echo '<textarea disabled id="previous_comments" rows="10" cols="50">'.$prevComms.'</textarea>';

        //     echo '<br><br><form method="post">';
        //     echo '<label for="comment">New Comment:</label><br>';
        //     echo '<textarea id="comment" name="comment" rows="10" cols="50" required></textarea>';
        //     echo '<br><br>';
        //     echo '<input type="submit" name="submit_comment" value="Add Comment"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        //     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="comment_and_close" value="Close Ticket"/>';
        //     echo '</form>';
        // }

        // // Update the ticket without closing it
        // if (isset($_POST['submit_comment'])) {

        //     GLOBAL $ticketID;

        //     $postedComment = $_POST['comment'];

        //     $userID = $_SESSION['User_ID'];

        //     $currentDateTime = date('Y-m-d H:i:s');
        //     $break = "-------------------------\r\n";

        //     $newComment = $break . $currentDateTime . "\r\n" . "User: " . $userID . "\r\n" . $break . $postedComment . "\r\n\r\n";

        //     $check = $ticket->addComment($con, $ticketID, $newComment);

        //     if ($check != "Success") {
        //         // Unable to add comment to ticket
        //         $errormsg = $ticket->getError();
        //         echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        //         $con->close();
        //         header("refresh:0; url=index.php");
        //     } else {
        //         // Ticket updated
        //         $msg = "Comment added";
        //         echo '<script type="text/javascript">alert("'.$msg.'");</script>';
        //         $con->close();
        //         header("refresh:0; url=index.php");
        //     }

        // }

        // // Update ticket and close it
        // if (isset($_POST['comment_and_close'])) {

        //     GLOBAL $ticketID;
        //     $postedComment = $_POST['comment'];

        //     $userID = $_SESSION['User_ID'];

        //     $currentDateTime = date('Y-m-d H:i:s');
        //     $break = "-------------------------\r\n";

        //     $newComment = $break . $currentDateTime . "\r\n" . "User: " . $userID . "\r\n" . $break . $postedComment . "\r\n\r\n";

        //     $check = $ticket->closeTicket($con, $ticketID, $newComment);

        //     if ($check != "Success") {
        //         // Unable to add comment to ticket
        //         $errormsg = $ticket->getError();
        //         echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
        //         $con->close();
        //         header("refresh:0; url=index.php");
        //     } else {
        //         // Ticket updated
        //         $msg = "Ticket has been updated and closed";
        //         echo '<script type="text/javascript">alert("'.$msg.'");</script>';
        //         $con->close();
        //         header("refresh:0; url=index.php");
        //     }

        // }
        
        ?>

    </div>

 </body>
</html>