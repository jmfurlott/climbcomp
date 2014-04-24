<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="./css/bootstrap.min.css" rel='stylesheet' type='text/css'>
    <link href="./site.css" rel='stylesheet' type='text/css'>
    <title>Welcome to climbcomp!</title>
</head>
<body>
    
    <!-- navigation bar at the top -->
    <div class="navbar navbar-inverse navbar-static-top navbar-inner">
        <div class="container">
            <a href="index.php" class="navbar-brand">climbcomp</a>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if(isset($_SESSION['logged_in']) && isset($_SESSION['email']) && $_SESSION['logged_in'] == 1) { 
                    ?>
                        <li><a>Welcome back, <?php echo $_SESSION['first_name'] ?>!</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php
                        } else {
                    ?>     
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>
                    <?php
                        }
                    ?>
                
                </ul>
            </div>
        </div>
    </div>
    
