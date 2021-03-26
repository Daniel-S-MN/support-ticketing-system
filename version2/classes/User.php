<?php

require('classes/DBConn.php');

class User extends DBConn {
    
    function login($userID, $password) {
        
        // Perform a MySQL search to see if that user exists in the users table
        $stmt = mysqli_query($this->connection, "SELECT *
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

}