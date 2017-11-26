<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("digestInclude.php");

$query = "SELECT * FROM user_info WHERE digest=1";
sendDigest($query,"oneHour.txt",-1);
?>
