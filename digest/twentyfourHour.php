<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("digestInclude.php");

//digest=4 is 24 hour option
$query = "SELECT * FROM user_info WHERE digest=4";
sendDigest($query,"twentyfourHour.txt",-24);
?>
