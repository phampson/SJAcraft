<?php
//Report Errors
error_reporting(E_ALL);
ini_set('display_errors', '1');

//Start Database Connection
$host= "localhost";
$username="root";
$userpass="ecs160web";
$databasew="web";
$mysqli = new mysqli($host,$username,$userpass,$databasew);
if ($mysqli->connect_errno){
    echo "Error connecting to Database";
    exit;
 }

//Begin Session
session_start();

?>
