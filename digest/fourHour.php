<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("digestInclude.php");

//digest=2 is four hour updates
$query = "SELECT * FROM user_info WHERE digest=2";
sendDigest($query,"fourHour.txt",-4);
?>
