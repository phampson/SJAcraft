<?php

session_start();//begin session

include('start.php');

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'select * from user_info where username="'.$username.'" and password="'.$password.'"';

$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
	$fetch = $query->fetch_assoc();
	$email_verify = $fetch['email_verfy'];
	$reset_pass = $fetch['reset_pass'];

	if ($email_verify != 0){//wrong for now for testing. should be ==0
		echo "email not verified ";	
	}
	else if ($reset_pass == 1){
		echo "password not reset";	
	}	
	else {
		echo "Welcome! ";
		echo $fetch['username'];
		$update = 'update user_info set logged="1" where username="'.$username.'"';
		if ($mysqli->query($update)) {
			echo " is online ";	
			$_SESSION['user_id'] = $username;
			header("Location: ../profile/profile.php");
		}
	}
}

else {
	echo "username or password invalid";
}

?>
