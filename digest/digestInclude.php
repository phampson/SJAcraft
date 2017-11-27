<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");

require '/home/ubuntu/ECS160WebServer/phpmailer/PHPMailer.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/SMTP.php';
require '/home/ubuntu/ECS160WebServer/phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function getUserMessages($userID, $time, $file)
{
    $mysqli = $GLOBALS["mysqli"];
    
    $msgQuery = "SELECT * FROM message WHERE receiver=$userID AND message_date>=DATE_ADD(NOW(), INTERVAL $time HOUR)";
    $list     = $mysqli->query($msgQuery);
    
    if ($list->num_rows > 0) {
        $msg = "You received " . $list->num_rows . " new message(s).<br>";
        fwrite($file, $msg);
    }
    
    
}


function getUserComments($userID, $time, $file)
{
    $mysqli       = $GLOBALS["mysqli"];
    $IP           = $_SERVER['HTTP_HOST'];
    // gets all the distinct posts the user has commented in
    $commentQuery = "SELECT DISTINCT(post_id) FROM comment WHERE comment_user=$userID";
    $list = $mysqli->query($commentQuery) or die($mysqli->error);
    
    while ($post = $list->fetch_assoc()) {
        $postID = $post["post_id"];
        
        $query      = "SELECT post_header FROM post WHERE post_id=$postID";
        $result     = $mysqli->query($query);
        $result     = $result->fetch_assoc();
        $postHeader = $result["post_header"];
        
        // get all new comments in posts where user has commented in
        $postQuery = "SELECT * FROM comment WHERE post_id=$postID AND comment_date>=DATE_ADD(NOW(), INTERVAL $time HOUR)";
        $comments  = $mysqli->query($postQuery);
        
        if ($comments->num_rows > 0) {
            $msg = "Thread '$postHeader' ($IP/forum/comments.php?postId=$postID) has " . $comments->num_rows . " new comment(s).<br>";
            fwrite($file, $msg);
        }
    }
}


function sendDigest($query, $filepath, $time)
{
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
    
    
    $result = $mysqli->query($query);
    
    while ($row = $result->fetch_assoc()) {
        $userID   = $row['id'];
        $username = $row["username"];
        
        $file = fopen($filepath, "w");
        
        getUserComments($userID, $time, $file);
        getuserMessages($userID, $time, $file);
        fclose($file);
        
        
        // open in loop so it gets overwritten each time
        $file = fopen($filepath, "r");
        $msg  = fread($file, filesize($filepath));
        fclose($file);
        
        
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
    $file = fopen($filepath, "w");
    fclose($file);
}
?>
