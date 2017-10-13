<?php

include('start.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'insert into user_info (username, password) values("'.$username.'", "'.$password.'")';
if ($mysqli->query($sql)) {
	echo "houston we don't have a problem";
}

else {
	echo "houston we do have a problem";
}

?>
