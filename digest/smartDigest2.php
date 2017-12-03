<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

echo "here <br>";
function sendDigest($query)
{

	    $mysqli = $GLOBALS["mysqli"];
	    $IP = $_SERVER['HTTP_HOST'];
	    
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
	    $mail->Subject = 'Warcraft II Email Digest: new unread message/comment';
	    $mail->AltBody = 'This is a plain-text message body'; // dunno if needed tbh
	    
	    
	    $result = $mysqli->query($query);
	    
	    while ($row = $result->fetch_assoc()) {
		$userID   = $row['id'];
		$username = $row["username"];
	
	    	$msg = "You have new unread message(s).<br>";
		
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
	   
}
echo "HERE <br>";
	// search through everyone that is subscribed to the post commented on and send them an email
	$friend_id = $argv[1];
	$new_comm_arr = array();
	echo $friend_id;
	$sql = "SELECT * FROM user_info WHERE id='" . $friend_id . "'AND smart = 1";
	$query = $mysqli->query($sql);
	if (mysqli_num_rows($query) != 0)
	{
		echo "1";
		//searches for who all the interactions 
		$sql2 = "SELECT * FROM friendlist WHERE user_id'" . $friend_id . "'AND newst_msgid != interact_msgid";
		$query2 = $mysqli->query($sql2);
		if (!$query2 || (mysqli_num_rows($query2) == 0))
		{
			echo "2";
			$sql3 = 'SELECT newest_comment_id FROM post';
			$query3 = $mysqli->query($sql3);
		
			while($row = mysqli_fetch_assoc($query3))
			{
				if ($row['newest_comment_id'] != NULL)
				{	
					$new_comm_arr[] = $row['newest_comment_id'];
				}
			}

			$imploded_comm = implode(',', $new_comm_arr);
			
			$sql4 = 'SELECT user_id FROM forum_digest where user_id =' . $friend_id . 'AND last_read_comment_id NOT IN (' . $imploded_comm . ')';
			$query4 = $mysqli->query($sql4);
								
			//if zero that means all last read commments were in the posts
			if(!$query4 || (mysqli_num_rows($query4) == 0)) {
				echo "3";
				$query5 = "SELECT * from user_info WHERE id=$friend_id";
				sendDigest($query5);
			}
		}
	}

	
?>
