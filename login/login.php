<?php
//start session and start logout timer
session_start();
$_SESSION['EXPIRES'] = time() + 300;//Change this value to increase or decrease the logout value
include('/home/ubuntu/ECS160WebServer/start.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'select * from user_info where username="'.$username.'" and password="'.$password.'"';

$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
	$fetch = $query->fetch_assoc();
	$email_verify = $fetch['email_verify'];
	$reset_pass = $fetch['reset_pass'];
	$_SESSION['user_id'] = $fetch['id'];
	$id = $fetch['id'];

	if ($email_verify == 0){//wrong for now for testing. should be ==0
		echo "email not verified ";	
	}
	else if ($reset_pass == 1){
		echo "password not reset";	
	}	
	else {
		echo "Welcome! ";
		echo $fetch['username'];
		$update = 'update user_info set web_logged="true" where id="'.$id.'"';
		if ($mysqli->query($update)) {
			echo " is online ";	
			header("Location: ../profile/profile.php");
		}
	}
}

else {
	echo "username or password invalid";
}

?>
