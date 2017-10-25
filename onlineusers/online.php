<?php 
include "start.php";
error_reporting(E_ALL); ini_set('display_errors', '1');

$user = array();
$sql = 'SELECT username, avatar_path, web_logged, game_logged  FROM user_info WHERE email_verify = 1';
$result=$mysqli->query($sql) or die("project query fail");
while($r = mysqli_fetch_assoc($result)) {
    $user[] = $r;
}
echo($user);
?>
