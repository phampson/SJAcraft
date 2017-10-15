<?php

include ('start.php');

$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'insert into user_info (username, password) values("'.$username.'", "'.$password.'")';
if($mysqli->query($sql)) {
	echo "Account created\n";
}

else {
	echo "Username already taken\n";
}

echo "email: ";
echo $email;
echo "\nusername: ";
echo $username; 

?>
