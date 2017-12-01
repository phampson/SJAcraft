<?php
include('/home/ubuntu/ECS160WebServer/start.php');

require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$email = "";
$username = "";

if (isset($_POST['email'])) {
    $email    = $_POST['email'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}

$check = 'select * from user_info where username="' . $username . '" and email="' . $email . '"';
/*$insert = 'insert into user_info (username, password, email, hash) values("'.$username.'", "'.$password.'", "'.$email.'", "'.$hash.'")';
 */
$query = $mysqli->query($check);
/*echo $query->num_rows;*/

if ($query->num_rows <= 0) {
    $pwmsg = "User Does Not Exist or you entered wrong email address";
} 
else if ($query->num_rows > 1) {
    $pwmsg = "Sorry, something wrong (more than one same user) , we will fix it";
} 
else {
    $row  = $query->fetch_assoc();
    $hash = $row['hash'];
    $msg  = '
------------------------
Username: ' . $username . '
E-mail: ' . $email . '
------------------------
 
Please click this link to reset your password:
' . $_SERVER['HTTP_HOST'] . '/login/resetpw.php?email=' . $email . '&hash=' . $hash . '
 
';
    
    
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;//Uncomment if debugging
    $mail->Host       = 'smtp.gmail.com';
    $mail->Port       = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth   = true;
    $mail->Username   = "ecs160test@gmail.com";
    $mail->Password   = "Pineapple1";
    $mail->setFrom('ecs160test@gmail.com', 'Web Team');
    $mail->addAddress($email, 'New user');
    $mail->Subject = 'Warcraft II Account Verification';
    $mail->Body    = "$msg";
    $mail->AltBody = 'This is a plain-text message body'; // dunno if needed tbh

    $pwmsg = "";
    
    if (!$mail->send()) {
        $pwmsg = "Mailer Error: " . $mail->ErrorInfo;
    } 
    else {
        $pwmsg = "Please check your email, you will receive a link to reset your password";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<link rel="stylesheet" href="stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Nav Bar -->
<div id="navbar"></div>
<script>
        $("#navbar").load("../navbar/navbar.html")
</script>

<!-- Login form -->
<div class="div1 col-xs-12 col-sm-6 col-sm-offset-3" id="border-gold">
        <h1 class="text-center">Reset Password</h1>
        <p><?php echo $pwmsg ?></p>
</div>

</body>
</html>
