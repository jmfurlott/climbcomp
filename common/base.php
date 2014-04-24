<?php

    //turn this off after developing
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
    //session_start();

    //our db constants
    include_once "inc/constants.inc.php"; //should this be ../inc?

    //now create the database
    try {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;
        $db = new PDO($dsn, DB_USER, DB_PASS);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }

?>

