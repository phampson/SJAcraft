<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("/home/ubuntu/ECS160WebServer/digest/digestInclude.php");
require_once('/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php');
require_once('/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php');
require_once('/home/ubuntu/ECS160WebServer/phpmailer/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//***MUST SEND IN user_id from uploadComments if using exec***

	// search through everyone that is subscribed to the post commented on and send them an email
	/*$ID = $argv[1];
	$lastComment = $argv[2];*/
	//searches for who is subscribed to the post
	$sql = 'SELECT user_id FROM forum_digest WHERE post_id =' . $ID; 
	$query = $mysqli->query($sql);
	$users = array();
	echo "<br>";
	echo "smart digest start";
	echo "<br>";
	while($row = mysqli_fetch_assoc($query))
	{
		$users[] = $row['user_id'];
		
	}
	
	echo "imploded_users";
	$imploded_users = implode(',', $users);
	print_r( $imploded_users);
	echo "<br>";
	//of those subscribed, find those who want smart digest
	$query2 = "SELECT * FROM user_info WHERE smart=1 AND id IN ($imploded_users)";
	$query2 = $mysqli->query($sql);
	$users2 = array();

	while($row2 = mysqli_fetch_assoc($query2))
	{
		$users2[] = $row2['user_id'];
	}

	echo  "users2";
	print_r($users2);
	echo "<br>";
	$int =  0;
	$realUsers = array();
	echo "I am:" . $user_id . "<br>";
	foreach ($users2 as $onePerson)
	{
		if($onePerson != $user_id) {
			//$int = $int + 1;
			//echo $int;
			echo "onePerson: ";
			echo $onePerson;
			echo "<br>"; 
			//finds if all last read comments are the same as the post's newest comment => up to date on notifications so send email
			$sql = 'SELECT * FROM forum_digest WHERE user_id = "' . $onePerson . '" AND post_id = "' . $ID . '" AND last_read_comment_id = "' . $lastComment . '";';
			//echo "lastComment: " . "$lastComment";
			//checks to make sure commented on post was all read already
			if (mysqli_num_rows($mysqli->query($sql)) != 0) {
	 			$sql2 = "SELECT user_id FROM forum_digest WHERE user_id=$onePerson AND last_read_comment_id != $lastComment AND last_read_comment_id NOT IN (SELECT newest_comment_id FROM post)";
				//$query2 = $mysqli->query($sql2);
				//if zero that means all last read commments were in the posts
				if(mysqli_num_rows($mysqli->query($sql2)) == 0) {
					array_push($realUsers,$onePerson);
					//$sql2 = "SELECT * FROM user_info WHERE user_id = $onePerson";
					//$query2 = $mysqli->query($sql2);
					//sendDigest($sql2, "smartDigest.txt", -0.40);
				}
			}
		
		
		}
	}

if (count($realUsers) != 0) {
	echo "<br>";
	echo "USers:";
	print_r($realUsers); //list of people to mail
	echo "<br>";
	$imploded_real = implode(',', $realUsers);
	$query2 = "SELECT * FROM user_info WHERE id IN ($imploded_real)";

	/////////////////// php mailer.

	$mysqli = $GLOBALS["mysqli"];
	    
	    // create php mailer object
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
	    $mail->Subject = 'Warcraft II Email Digest';
	    $mail->AltBody = 'This is a plain-text message body'; // dunno if needed tbh
	    
	    
	    $result = $mysqli->query($query2);
	    
	    while ($row = $result->fetch_assoc()) {
		$userID   = $row['id'];
		$username = $row["username"];
		
		//$file = fopen("smartDigest.txt", "w");
	    	$msg = "Smart updates: You have at least one new message and/or comment on a post you're subscribed to";
		
		//fwrite($file, $msg);
		//fclose($file);
		
		// open in loop so it gets overwritten each time
		//$file = fopen("smartDigest.txt", "r");
		//$msg  = fread($file, filesize("smartDigest"));
		//fclose($file);
		
		$mail->addAddress($row["email"], "SJACraft II Email Digest");
		
		// only send email if there were notifications
		if ($msg != "") {
		    $mail->Body = "Hello, $username!<br>" . $msg;
		    if (!$mail->send()) {
		        echo "Mailer error: " . $mail->ErrorInfo;
		    }
		}
		
		// addAddress() adds to a list, so clear that list (oopsies)
		$mail->ClearAllRecipients();
	    }
	    
	    // open and close file outside of loop to clear contents
	    //$file = fopen("smartDigest.txt", "w");
	    //fclose($file);

	///////////////////
}

?>
