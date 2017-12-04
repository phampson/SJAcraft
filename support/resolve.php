<?php
include('/home/ubuntu/ECS160WebServer/start.php');

require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_GET['bugID'])) {
    $sql   = "select * from support where bug_id=" . $_GET['bugID'];
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch = $query->fetch_assoc();
	$posterID = $fetch['user_id'];
	$subject = $fetch['title'];
	$contents = $fetch['details'];
	$sql2 = "select * from user_info where id=" . $posterID;
	$query2 = $mysqli->query($sql2);
	if($query2) {
		$fetch2 = $query2->fetch_assoc();
		$posterEmail = $fetch2['email'];
		$posterName = $fetch2['username'];
		echo $posterEmail;
	}
        $update  = "UPDATE support SET resolved = 'true' where bug_id='".$_GET['bugID']."'";
        if ($mysqli->query($update)) {
        	echo "it worked. ";
    	}
    	else {
    		echo "not yet";
    	}
    }
    // if GET[ID] is set, you're trying to view someone else's profile,
    // so grab their info

$msg = '
 
    Hello ' . $posterName . ', 
    <br><br>
    We have resolved the error you reported as: ' . $contents . '.
    <br><br>
    Thank you for bringing that error to our attention. We hope you continue enjoying your experience with the Warcraft 2 Community.
         
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
        $mail->addAddress($posterEmail, 'Error poster');
        $mail->Subject = "Resolved error: $subject";
        $mail->Body    = "$msg";
        $mail->AltBody = 'This is a plain-text message body'; // dunno if needed tbh
	if (!$mail->send()) {
		echo "no luck";
        } 
    header('Location: ' . '../support/support.php');
}
?>
