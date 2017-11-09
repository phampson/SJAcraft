<?php
include('/home/ubuntu/ECS160WebServer/start.php');

require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];
$hash = $mysqli->escape_string(md5(rand(0,1000)));

$check = 'select * from user_info where username="'.$username.'"';
$insert = 'insert into user_info (username, password, email, avatar_path, hash) values("'.$username.'", "'.$password.'", "'.$email.'", "avatar_pics/profile_default.jpg", "'.$hash.'")';

$query = $mysqli->query($check);
if ($query->num_rows > 0) {
	echo "Username already taken";
} else {

	if($mysqli->query($insert)) {
		echo "Account created ";
		echo "username: ";
		echo $username;

		$msg  = '
 
    Thanks for signing up!
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
     
    ------------------------
    Username: '.$username.'
    ------------------------
     
    Please click this link to activate your account:
    '.$_SERVER['HTTP_HOST'].'/signup/verification.php?email='.$email.'&hash='.$hash.'
     
    '; // Our message above including the link

    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;//uncomment if debugging
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "ecs160test@gmail.com";
    $mail->Password = "Pineapple1";
    $mail->setFrom('ecs160test@gmail.com', 'Web Team');
    $mail->addAddress($email, 'New user'); 
    $mail->Subject = 'Warcraft II Account Verification';
    $mail->Body = "$msg";
    $mail->AltBody = 'This is a plain-text message body'; // dunno if needed tbh

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "<br>Please verify your account!";
    }
  }
}
?>
