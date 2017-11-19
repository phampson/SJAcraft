<?php

include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("/home/ubuntu/ECS160WebServer/digest/digestInclude.php");

/*require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;*/

// search through everyone that is subscribed to the post commented on and send them an email
	$sql = "SELECT user_id FROM forum_digest WHERE post_id = '$ID'"; 
	$query = $mysqli->query($sql);
	$users = array();
	

	while($row = mysqli_fetch_array($query))
	{	print_r($row);
		$users[] = $row['user_id'];		
	}
	
	$imploded_users = implode(',', $users);

	$query = "SELECT * FROM user_info WHERE digest=1 AND id IN ($imploded_users)";
	
	sendDigest($query, "smartDigest.txt", -0.00555);
?>
