<?php

require_once('classes/DBConn.php');

class User extends DBConn {
    
    function login($userID, $password) {

        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (is_array($row)) {
            if ($password == $row['password']) {
                session_start();
                $_SESSION['login'] = "yes";
                $_SESSION['User_ID'] = $row['user_id'];
                $_SESSION['First_Name'] = $row['first_name'];
                $_SESSION['Last_Name'] = $row['last_name'];
                $_SESSION['Email'] = $row['email'];
                $_SESSION['Phone_Num'] = $row['phone_number'];
                $_SESSION['Department'] = $row['department'];
                $_SESSION['Position'] = $row['position'];

            return true;

            } else {
                $this->error = "Invalid Password";
                return false;
            }
        } else {
            $this->error = "User not found";
            return false;
        }
    }
}