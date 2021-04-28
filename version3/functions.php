<?php

/**
 * Here is where all the common code shared between multiple pages will be stored. This will allow for
 * pages to be more clean and easy to read, rather than re-using several lines of the same code
 * for multiple pages.
 */

 function onlyAdminAccess() {

    // Make sure that IT Support Managers can access the page
    if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
        header("Location: login.php");
        exit();
    } elseif ($_SESSION['Access'] != 3) {
        header("Location: index.php");
    }
 }

 function onlyITAccess() {

    // Make sure that only IT Support can access the page
    if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
        header("Location: login.php");
        exit();
    } elseif ($_SESSION['Access'] < 2) {
        header("Location: index.php");
    }
 }

 function mustBeLoggedIn() {

    // Make sure only people logged in can view this page
    if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
        header("Location: login.php");
        exit();
    }
 }

function showITManagerMenu() {

    // Display the menu options for IT Support managers (admin)
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

function showITSupportMenu() {

    // Display the menu options for IT Support non-managers
    echo '<li><a href="#troubleshooting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-wrench" aria-hidden="true"></i> Troubleshooting</a>';
        echo '<ul class="collapse list-unstyled" id="troubleshooting">';
            echo '<li><a href="open_tickets.php">Open Tickets</a></li>';
            echo '<li><a href="assigned_tickets.php">Tickets Assigned To Me</a></li>';
        echo '</ul>';
    echo '</li>';
    echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
    echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
    echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';
}

function showNonITMenu() {

    // Display the menu options for non-IT users
    echo '<li><a href="create_ticket.php"><i class="fa fa-ticket" aria-hidden="true"></i> Create Ticket</a></li>';
    echo '<li><a href="my_tickets.php"><i class="fa fa-tags" aria-hidden="true"></i> My Tickets</a></li>';
    echo '<li><a href="my_profile.php"><i class="fa fa-address-card" aria-hidden="true"></i> My Profile</a></li>';
}

function tableWithoutAssign() {

    // Create the table and table header columns, without the "assigned to" column
    echo '<table class="table table-hover table-bordered">';
    echo '<thead>';
        echo '<tr>';
            echo '<th>Ticket ID</th>';
            echo '<th>Date Created</th>';
            echo '<th>Priority</th>';
            echo '<th>Created By</th>';
            echo '<th>Title</th>';
            echo '<th>Details</th>';
        echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
}

function tableWithAssign() {

    // Create the table and table header columns with the "assigned to" column
    echo '<table class="table table-hover table-bordered">';
    echo '<thead>';
        echo '<tr>';
            echo '<th>Ticket ID</th>';
            echo '<th>Date Created</th>';
            echo '<th>Priority</th>';
            echo '<th>Created By</th>';
            echo '<th>Title</th>';
            echo '<th>Assigned To</th>';
            echo '<th>Details</th>';
        echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
}

function sendRecoveryEmail($email, $password) {

    $subject = "Support Ticket System - Password Reset";

    $message = "<h1>Temporary Password Request</h1><br>";
    $message .= "<h2>Here is your temporary password: ".$password."</h2>";
    $message .= "\n\nPlease remember to change your password after logging back in.";

    $header = "From:ics499.spring2021.group5@gmail.com \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";

    // Attempt to send the email with the temporary password to the user
    return $retval = mail($email, $subject, $message, $header);
}

function getTempPassword() {

    // Returns a randomly generated 10 character password
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*";
    $tempPassword = substr(str_shuffle($chars), 0, 10);

    return $tempPassword;
}