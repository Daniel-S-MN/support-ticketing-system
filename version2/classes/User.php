<?php

require('classes/DBConn.php');

class User extends DBConn {
    
    function login($userID, $password) {

        $stmt = $this->connection->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $stmt->rowCount();

        if ($count < 1) {
            $this->error = "No user found";
            return false;
        } else {
            $stmt->bind_result($uid, $passcode, $fName, $lName, $email, $phoneNum, $dept, $position);
            
            // Verify the entered password with the hashed password in the DB
            $verify = password_verify($password, $passcode);
            if ($verify) {
                session_start();
                $_SESSION['login'] = "yes";
                $_SESSION['User_ID'] = $uid;
                $_SESSION['First_Name'] = $fName;
                $_SESSION['Last_Name'] = $lName;
                $_SESSION['Email'] = $email;
                $_SESSION['Phone_Num'] = $phoneNum;
                $_SESSION['Department'] = $dept;
                $_SESSION['Position'] = $position;
                return true;
                
            } else {
                $this->error = "Invalid password";
                return false;
            }
        }
    }

}