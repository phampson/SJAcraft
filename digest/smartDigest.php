<?php
echo "UP here";
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("/home/ubuntu/ECS160WebServer/digest/digestInclude.php");

/*require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;*/

// search through everyone that is subscribed to the post commented on and send them an email
	/*sleep(5);
	echo "HERE";
	print_r("HERE2");
	print_r($_SERVER['argv']);
	$ID = escapeshellarg($ID);
	var_dump($argv);
	print_r($argv);
	echo($argv);
	//$lastComment = escapeshellarg($lastComment);*/
	$sql = "SELECT user_id FROM forum_digest WHERE post_id = '$ID' AND last_read_comment_id = '$lastComment'"; 
	//echo $ID;
	//echo $lastComment;
	$query = $mysqli->query($sql);
	$users = array();
	

	while($row = mysqli_fetch_array($query))
	{	$users[] = $row['user_id'];		
	}
	
	$imploded_users = implode(',', $users);

	$query = "SELECT * FROM user_info WHERE smart=1 AND id IN ($imploded_users)";

	sendDigest($query, "smartDigest.txt", -0.000005);

	phpInfo();
?>
