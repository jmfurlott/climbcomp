<?php

//simply unset the session and return to the index
    session_start();
    unset($_SESSION['logged_in']);
    unset($_SESSION['email']);
    unset($_SESSION['user_id']);
    unset($_SESSION['first_name']);

?>

<meta http-equiv="refresh" content="0;login.php">
