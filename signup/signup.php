<?php

include ('start.php');

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$check = 'select * from user_info where username="'.$username.'"';
$insert = 'insert into user_info (username, password, email) values("'.$username.'", "'.$password.'", "'.$email.'")';

$query = $mysqli->query($check);
if ($query->num_rows > 0) {
	echo "Username already taken";
}

else {

	if($mysqli->query($insert)) {
		echo "Account created ";
		echo "username: ";
		echo $username;
	}

	else {
		echo "Error";
	}
}

?>
