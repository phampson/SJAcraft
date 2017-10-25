<?php 
include "start.php";
error_reporting(E_ALL); ini_set('display_errors', '1');
$sql = 'SELECT username FROM user_info WHERE game_logged = "true" OR web_logged = "true"';
$result=$mysqli->query($sql) or die("project query fail");
$totalpath = "";
while($label = $result->fetch_row())
{$totalpath=$totalpath.",".$label[0];}
echo $totalpath;

?>
