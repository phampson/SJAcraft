<?php
include('/home/ubuntu/ECS160WebServer/start.php');

require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['user_id'])) {
    $sql   = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch      = $query->fetch_assoc();
        $username   = $fetch['username'];
        $email      = $fetch['email'];
        $avatarPath = $fetch['avatar_path'];
        $navpath    = "../navbar/navbarlogged.html";
    }
} 
else {
    $navpath = "../navbar/navbarlogged.html";
}

$friendemail = $_POST['friendemail'];



$msg = '
 
    Hello,
    <br><br>
    You have been invited to join the Warcraft 2 community by the following player: ' . $username . '.
    <br><br>
    If you would like to sign up and join the community, please click on the following link:
    ' . $_SERVER['HTTP_HOST'] . '/signup/signup.html
     
    <br><br>
    Best,
    <br>Web Team
     
    '; // Our message above including the link

	//Create a new PHPMailer instance
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;//uncomment if debugging
        $mail->Host       = 'smtp.gmail.com';
        $mail->Port       = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth   = true;
        $mail->Username   = "ecs160test@gmail.com";
        $mail->Password   = "Pineapple1";
        $mail->setFrom('ecs160test@gmail.com', 'Web Team');
        $mail->addAddress($friendemail, 'Referred friend');
        $mail->Subject = 'Warcraft II Invitation';
        $mail->Body    = "$msg";
        $mail->AltBody = 'This is a plain-text message body'; // dunno if needed tbh

	if (!$mail->send()) {
		echo "no luck";
        } 

header('Location: ' . 'profile.php');
?>
