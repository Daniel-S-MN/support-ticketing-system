<?php

// This will just end the current session and redirect to the login

session_start();

header('Location: index.php');

session_destroy();