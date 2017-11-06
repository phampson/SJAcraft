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
	$msg = '
------------------------
Username: '.$username.'
E-mail: '.$email.'
------------------------
 
Please click this link to reset your password:
'.$_SERVER['HTTP_HOST'].'/login/resetpw.php?email='.$email.'&hash='.$hash.'
 
'; 



	$mail = new PHPMailer;
  $mail->isSMTP();
  $mail->SMTPDebug = 2;
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
      echo "Please verify your account!";
  }
}

?>
