<?php

// TODO: need to update this class with the new database

require_once('classes/Database.php');

class User extends Database {

    public $error;
    
    // Check to see if the user is able to log into the system
    function login($con, $username, $password) {
        
        // Perform a MySQL search to see if that user exists in the users table
        $stmt = mysqli_query($con, "SELECT *
                                    FROM users
                                    WHERE username = '$username'");
        $row = mysqli_fetch_array($stmt);
        
        // Determine if the MySQL search found the user
        if (!is_array($row)) {
            $this->error = "User not found";
            return false;
        } else {
            // Verify that the password matches with the hashed password in the DB
            $passcode = $row['password'];
            $verify = password_verify($password, $passcode);

            if (!$verify) {
                $this->error = "Incorrect password";
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
            $this->error = "Unable to add user: " . mysqli_error($con);
            return NULL;
        }
    }

    // TODO: make sure I don't ACTUALLY need this function anymore...
    // // Get all the users from a specific department
    // function getDepartment($con, $department) {
        
    //     $query = "SELECT username 
    //         FROM users 
    //         WHERE department='$department'";
        
    //     if ($result = mysqli_query($con, $query)) {
    //         return $result;
    //     } else {
    //         $this->error = "Unable to process department query: " . mysql_error();
    //         return NULL;
    //     }
    // }

    // Get all of the users from the DB
    function getAllUsers($con) {

        $query = "SELECT username, f_name, l_name, email, phone_num, department, title 
        FROM users";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysql_error();
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