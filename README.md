# ICS 499 Captstone - Spring 2021
Group Members: Ken Thao and Daniel Schwen

This is a simple support ticketing system that will allow users to create and
submit tickets for any issues/requests they may have. It will be updated 
throughout the semester until May 28th (when the project is due).

# USERS
There are really three users:

( 1 ) Non-IT users

These are the "customers" in the project scenario. They are the 
going to be submitting the majority of tickets. These are the users
that we MUST ensure can use the ticketing system on their mobile
devices.

( 2 ) IT Support (non-managers)

These are the users who are going to be supporting the customers. They
will be assigning open tickets to themselves to troubleshoot. While
these users can access the site from their mobile devices, it's really
not intended for them to do so.

( 3 ) IT Support (managers)

Think of these users as the "admin". They have all the functionality of
the non-manager IT Support, but have the additional functionality of a
traditional admin role as well. 

The biggest difference between the manager and non-manager users is that
the managers can assign open tickets to someone other than themselves, 
re-assign pending tickets, create new users in the ticket system, and 
update user profiles (promotions or adding termination dates).

# SCOPE
The group determined at the start of the semester that this project should be a 
web application, rather than a desktop application. An emphasis was placed on the 
ability for users to be able to use the system on their desktop, laptop, tablet, or 
even their phone.

# MOBILE USE
While the IT Support team can technically use the site on their mobile devices, this
feature is primarily focused on the non-IT Support users. Due to this design decision,
many of the IT Support options will not be displayed when accessing the site on a 
mobile device.

# ACCESS
Here's a quick overview of what options/pages are available for each user:
 - Users
 	* Home
 	* Create Ticket
 	* My Tickets (view all the tickets they've created)
 	* My Profile (see their information and change their password)
 	* Logout
 
 - IT Support Agents
 	* Home
 	* Open Tickets (view all unassigned tickets that are open)
 	* Assigned Tickets (tickets that are assigned to them to work on)
 	* Create Ticket (same as users)
 	* My Tickets (same as uers)
 	* My Profile (same as uers)
 	* Logout
 	
 	
 - IT Support Managers (admin)
 	* Home
 	* Open Tickets (same as agents)
 	* Pending Tickets (view and re-assign tickets that are pending)
 	* Assigned Tickets (same as agents)
 	* Create Ticket (same as users and agents)
 	* My Tickets (same as users and agents)
 	* My Profile (same as uers and agents)
 	* System Users (view system users and update their information)
 	* New User (add a new user to the system)
 	* Logout
