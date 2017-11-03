<?php
include('/home/ubuntu/ECS160WebServer/start.php');

$email = $_POST['email'];
$username = $_POST['username'];

$check = 'select * from user_info where username="'.$username.'" and email="'.$email.'"';
/*$insert = 'insert into user_info (username, password, email, hash) values("'.$username.'", "'.$password.'", "'.$email.'", "'.$hash.'")';
*/
$query = $mysqli->query($check);
/*echo $query->num_rows;*/

if ($query->num_rows <= 0) {
	echo "User Not Exist or you entered wrong email address";
} else if ($query->num_rows > 1) {
	echo "Sorry, something wrong (more than one same user) , we will fix it";
} else {
	$row = $query->fetch_assoc();
	$hash = $row['hash'];
	$msg = $message = '
------------------------
Username: '.$username.'
E-mail: '.$email.'
------------------------
 
Please click this link to reset your password:
'.$_SERVER['HTTP_HOST'].'/login/resetpw.php?email='.$email.'&hash='.$hash.'
 
'; // Our message above including the link
	if(mail($email,"No-reply Reset your password",$msg,"From:ecs160test@gmail.com")) {
		echo "Reset link are sent, please check  your email!";
	} else {
		echo "Fail to sent reset email";
	}

}

?>
