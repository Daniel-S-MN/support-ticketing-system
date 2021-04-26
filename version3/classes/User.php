<?php

// TODO: need to update this class with the new database

require_once('classes/Database.php');

class User extends Database {

    public $error;
    
    // Check to see if the user is able to log into the system
    function login($con, $username, $password) {
        
        // Check if the user is in the users table in the DB
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows != 1) {
            // For security reasons, we can't let bad-actors start randomly guessing
            // usernames, in an attempt to gain access to the site or permissions
            $this->error = "Invalid username or password";
            return false;
        } else {
            // TODO testing
            $row = $result->fetch_assoc();

            // Verify that the password matches with the hashed password in the DB
            $passcode = $row['password'];
            $verify = password_verify($password, $passcode);

            if (!$verify) {
                // For security reasons, can't let the error message state that the
                // entered usename is correct, but the password is wrong.
                $this->error = "Invalid username or password";
                return false;
            } else {
                // Set the session for the user
                session_start();
                $_SESSION['login'] = "yes";
                $_SESSION['Username'] = $row['username'];
                $_SESSION['Password'] = $password;
                $_SESSION['First_Name'] = $row['f_name'];
                $_SESSION['Last_Name'] = $row['l_name'];
                $_SESSION['Email'] = $row['email'];
                $_SESSION['Phone_Num'] = $row['phone_num'];
                $_SESSION['Department'] = $row['department'];
                $_SESSION['Title'] = $row['title'];
                $_SESSION['Access'] = $row['level'];

                return true;
            }
        }
    }

    /**
     * If a user logs in for the first time, or if they had to use the "forgot password"
     * feature to log back into the system, they will be "flagged" as needing to change
     * their password.
     */
    function passwordResetCheck($con, $username) {

        // Check if the user is flagged for needing to update their password in the DB
        $stmt = $con->prepare("SELECT * FROM userstatus WHERE username = ? AND password_reset = 'yes'");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows != 1) {
            // The user isn't flagged
            return false;
        } else {
            // The user needs to change their password
            return true;
        }
    }

    // Verify user identity for a password reset request
    function forgotPasswordCheck($con, $username, $email) {

        // Check if the user is in the users table in the DB
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows != 1) {
            // For security reasons, can't just say "invalid email" or "invalid username"
            $this->error = "Invalid username or email address";
            return false;
        } else {
            return true;
        }
    }

    // Add a new user to the DB
    function addUser($con, $username, $psw, $fName, $lName, $email, $phone, $dept, $title, $level) {

        // Can't store plaintext passwords in the DB
        $passcode = password_hash($psw, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, password, f_name, l_name, email, phone_num, department, title, level)
        VALUES ('$username', '$passcode', '$fName', '$lName', '$email', '$phone', '$dept', '$title', '$level')";

        if (mysqli_query($con, $sql)) {
            // User was successfully added to the DB
            return "Success";
        } else {
            // Couldn't add the user, return the error
            $this->error = "Unable to add user: " . mysqli_error($con);
            return "Fail";
        }
    }

    // Flag the database that the user is new and needs to change their password AND set their security questions
    function flagNewUser($con, $username) {

        $sql = "INSERT INTO userstatus (username)
                VALUES ('$username')";
        
        if (mysqli_query($con, $sql)) {
            // User was successfully flagged as a new user in the DB
            return "Success";
        } else {
            // Couldn't flag the user, return the error
            $this->error = "Unable to add user: " . mysqli_error($con);
            return NULL;
        }
    }

    /*
     * If a user cannot remember their password, we will provide them with a way to set their own security questions 
     * and answers. This way, they can recover their password on their own. If they are unable to answer their own
     * security questions, they will need to reach out to their supervisor/manager, who can then submit a ticket for
     * a password request on the user's behalf.
    */
    function setQuestions($con, $username, $q1, $q2, $q3, $q4, $q5) {

    }

    /*
     * Both the security questions (above) and the answers to the questions (below) will be encrypted/decrypted using
     * a Cryptography Exstension called OpenSSL. Here's where I found out how to do this:
     * 
     * https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-a-php-string/
     * 
    */
    function setAnswers($con, $username, $ans1, $ans2, $ans3, $ans4, $ans5) {

    }

    // Flag the database that the user needs to reset their password
    function flagPswdReset($con, $username) {

        $sql = "UPDATE userstatus
                SET password_reset = 'Yes'
                WHERE userstatus.username = '$username'";
        
        if (mysqli_query($con, $sql)) {
            // User was successfully flagged as needing to change their password in the DB
            return "Success";
        } else {
            // Couldn't flag the user, return the error
            $this->error = "Unable to flag password reset: " . mysqli_error($con);
            return NULL;
        }
    }

    // Change the "password reset flag" to "no" in the DB
    function resetPswrdResetFlag($con, $username) {

        $sql = "UPDATE userstatus
                SET password_reset = 'No'
                WHERE userstatus.username = '$username'";
        
        if (mysqli_query($con, $sql)) {
            // User was successfully flagged as needing to change their password in the DB
            return true;
        } else {
            // Couldn't flag the user, return the error
            $this->error = "Unable to flag password reset: " . mysqli_error($con);
            return false;
        }
    }

    // Used to display all the users in IT Support
    function getITReps($con) {

        $query = "SELECT * FROM users WHERE level != 1";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            // This shouldn't be possible, but whatever
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get all of the users from the DB
    function getAllUsers($con) {

        $query = "SELECT username, f_name, l_name, email, phone_num, department, title 
        FROM users";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Get a specific user from the DB (this is only used with edit_users.php)
    function getUserInfo($con, $username) {
        
        $query = "SELECT * FROM users WHERE username = '$username'";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            // This shouldn't be possible, but whatever
            $this->error = "Error processing query. " . mysqli_error($con);
            return NULL;
        }
    }

    // Update the user information in the DB (this is only used with edit_users.php)
    function updateUser($con, $username, $fName, $lName, $email, $phone, $dept, $title, $level) {
        
        $sql = "UPDATE users
                SET 
                    f_name = '$fName',
                    l_name = '$lName',
                    email = '$email',
                    phone_num = '$phone',
                    department = '$dept',
                    title = '$title',
                    level = '$level'
                WHERE
                    username = '$username';";
        
        if (mysqli_query($con, $sql)) {
            // User information was successfully updated
            return "Success";
        } else {
            // Couldn't update the user information
            $this->error = "Unable to update user info: " . mysqli_error($con);
            return NULL;
        }
    }

    // Change the user's password
    function changePassword($con, $username, $password) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users
                SET password = '$hash'
                WHERE users.username = '$username'";
        
        if (mysqli_query($con, $sql)) {
            // Password was successfully updated
            return "Success";
        } else {
            // Couldn't update the password
            $this->error = "Unable to update password: " . mysqli_error($con);
            return NULL;
        }
    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }

}