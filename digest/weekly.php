<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("digestInclude.php");

//digest=5 is weekly option
$query = "SELECT * FROM user_info WHERE digest=5";
sendDigest($query,"weekly.txt",-168);
?>
