<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("digestInclude.php");

//digest=2 is 8 hour option
$query = "SELECT * FROM user_info WHERE digest=2";
sendDigest($query,"eightHour.txt",-8);
?>
