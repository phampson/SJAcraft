<?php

include('start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
	$id = $_SESSION['user_id'];
	$sql = "update user_info set web_logged='false' where id=$id";
	$query = $mysqli->query($sql);
}

session_destroy();
header("Location: ../index.php");
?>
