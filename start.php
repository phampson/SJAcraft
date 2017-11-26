<?php
//Report Errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Start Database Connection
$host      = "localhost";
$username  = "root";
$userpass  = "ecs160web";
$databasew = "web";
$mysqli    = new mysqli($host, $username, $userpass, $databasew);
if ($mysqli->connect_errno) {
    echo "Error connecting to Database";
    exit;
}

//Begin Session
session_start();

//Delete session after inactivity and log user out
if (!isset($_SESSION['EXPIRES']) || $_SESSION['EXPIRES'] < time()) {
    if (isset($_SESSION['user_id'])) {
        $id    = $_SESSION['user_id'];
        $sql   = "update user_info set web_logged='false' where id=$id";
        $query = $mysqli->query($sql);
    }
    session_destroy();
    $_SESSION = array();
}
?>