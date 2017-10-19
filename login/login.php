<?php

session_start();//begin session

include('start.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'select * from user_info where username="'.$username.'" and password="'.$password.'"';

$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
	echo "Welcome! $username";
	$update = 'update user_info set logged="1" where username="'.$username.'"';
	if ($mysqli->query($update)){
		$_SESSION['user_id'] = $username;
		header("Location: ../forum/test.php");
	}
}

else {
	echo "username or password invalid";
}

?>
