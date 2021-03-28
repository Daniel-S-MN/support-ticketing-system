<?php

//require('classes/DBConn.php');

class User {

    public $error;
    
    // Check to see if the user is able to log into the system
    function login($con, $userID, $password) {
        
        // Perform a MySQL search to see if that user exists in the users table
        $stmt = mysqli_query($con, "SELECT *
                                    FROM users
                                    WHERE user_id = '$userID'");
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
                $_SESSION['User_ID'] = $row['user_id'];
                $_SESSION['User_Passcode'] = $password;
                $_SESSION['First_Name'] = $row['first_name'];
                $_SESSION['Last_Name'] = $row['last_name'];
                $_SESSION['Email'] = $row['email'];
                $_SESSION['Phone_Num'] = $row['phone_number'];
                $_SESSION['Department'] = $row['department'];
                $_SESSION['Position'] = $row['position'];

                return true;
            }
        }
    }

    // Get all the users from a specific department
    function getDepartment($con, $department) {
        $query = "SELECT user_id 
            FROM users 
            WHERE department='$department'";
        
        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Unable to process department query: " . mysql_error();
            return NULL;
        }
    }

    // Get all of the users from the DB
    function getAllUsers($con) {

        $query = "SELECT user_id, first_name, last_name, email, phone_number, department, position 
        FROM users";

        if ($result = mysqli_query($con, $query)) {
            return $result;
        } else {
            $this->error = "Error processing query. " . mysql_error();
            return NULL;
        }
    }

    function getError() {
        $error = $this->error;
        unset($this->error);
        return $error;
    }

}