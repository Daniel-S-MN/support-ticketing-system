<?php

/**
 * Here is where all the common code shared between multiple pages will be stored. This will allow for
 * pages to be more clean and easy to read, rather than re-using several lines of the same code
 * for multiple pages.
 */

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