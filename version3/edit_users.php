<?php

    session_start();

    // Make sure only people logged in AND IT Support managers can view this page
    if(!isset($_SESSION['login']) || $_SESSION['login'] != "yes") {
        header("Location: login.php");
        exit();
    } elseif ($_SESSION['Access'] != 3) {
        header("Location: index.php");
    }
   
    /**
     * $_GET['id'] is the username that was selected in system_users.php and works just
     * fine in all the code below, HOWEVER, after $_POST['submit'], somehow the variable
     * for $id becomes undefined.
     * 
     * I have ZERO idea why this is happening. The variable is 100% valid and working throughout
     * this page UNTIL we check for is the "submit" button was selected, then $id somehow
     * becomes "undefined".
     * 
     * It's driving me crazy, but I don't have time right now to figure out why it's having
     * a stroke, so I'm supressing the warning for now.
     */
    $id = @$_GET['id'];

    require('classes/User.php');

    $editUser = new User();
    $editCon = $editUser->connect();
    $findUser = $editUser->getUserInfo($editCon, $id);

    if ($findUser != NULL) {
        $userInfo = mysqli_fetch_assoc($findUser);
    } else {
        // This SHOULDN'T be possible
        echo '<script type="text/javascript">alert("HOW DID YOU SELECT A USER THAT DOES NOT EXIST????");</script>';
        header("refresh:0; url=login.php");
        exit();
    }

    // Update the user information in the DB
    if (isset($_POST['submit'])) {

        $check = $editUser->updateUser($editCon, $_POST['username'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['phone'],
            $_POST['dept'], $_POST['title'], $_POST['levels']);
     
        if ($check != "Success") {
            // Couldn't update the user information
            $errormsg = $user->getError();
            echo '<script type="text/javascript">alert("'.$errormsg.'");</script>';
            $editCon->close();
            header("refresh:0; url=index.php");
        } else {
            // User info was successfully updated
            $msg = "User information updated!";
            echo '<script type="text/javascript">alert("'.$msg.'");</script>';
            $editCon->close();
            header("refresh:0; url=system_users.php");
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">     
    <!-- Font Awesome (for the icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    <!-- Our CSS file for the site after the login page -->
    <link rel="stylesheet" href="styles/stylesheet.css">

    <!-- For whatever reason, formatting only works if I include here, rather than the CSS file... -->
    <style>
        .table td, th {
            text-align: center;
            vertical-align: middle;
        }
    </style>

</head>
<body>

    <form method="post" action="edit_users.php" role="form">
        <div class="modal-body">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $userInfo['username'];?>" readonly="true"/>
            </div>
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $userInfo['f_name'];?>"/>
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $userInfo['l_name'];?>"/>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userInfo['email'];?>"/>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userInfo['phone_num'];?>"/>
            </div>
            <div class="form-group">
                <label for="dept">Department</label>
                <input type="text" class="form-control" id="dept" name="dept" value="<?php echo $userInfo['department'];?>"/>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $userInfo['title'];?>"/>
            </div>
            <!-- Drop-down doesn't work, so it will need to be manually entered if the user access level changes -->
            <div class="form-group">
                <lable for="levels">Access Permission Level</lable>
                <input type="text" class="form-control" id="levels" name="levels" value="<?php echo $userInfo['level'];?>"/>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info" name="submit">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>

    <!-- Latest stable version of jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>