<?php

include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("digestInclude.php");
//digest=3 is 16 hour option
$query = "SELECT * FROM user_info WHERE digest=3";
sendDigest($query,"sixteenHour.txt",-16);

?>
