<?php
include ('start.php');

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$hash = $mysqli->escape_string(md5(rand(0,1000)));

$check = 'select * from user_info where username="'.$username.'"';
$insert = 'insert into user_info (username, password, email, hash) values("'.$username.'", "'.$password.'", "'.$email.'", "'.$hash.'")';

$query = $mysqli->query($check);
if ($query->num_rows > 0) {
	echo "Username already taken";
} else {

	if($mysqli->query($insert)) {
		echo "Account created ";
		echo "username: ";
		echo $username;

		$msg = $message = '
 
Thanks for signing up!
Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
 
------------------------
Username: '.$username.'
Password: '.$password.'
------------------------
 
Please click this link to activate your account:
52.37.38.192/signup/verification.php?email='.$email.'&hash='.$hash.'
 
'; // Our message above including the link
		mail("davidatomassi@gmail.com","Test",$msg,"From:ecs160test@gmail.com");
		echo "<br> Go verify your email!";
	} else {
		echo "Error";
	}
}

?>
