<?php
$host      = "localhost";
$username  = "root";
$userpass  = "ecs160web";
$databasew = "web";
$mysqli    = new mysqli($host, $username, $userpass, $databasew);
if ($mysqli->connect_errno) {
    echo "huston we have a problem";
}
//else echo "success";
/*echo $mysqli->host_info;
 */
?>
