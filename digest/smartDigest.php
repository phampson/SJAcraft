<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");
include_once("/home/ubuntu/ECS160WebServer/digest/digestInclude.php");

// search through everyone that is subscribed to the post commented on and send them an email

$ID          = $argv[1];
$lastComment = $argv[2];
$sql         = "SELECT user_id FROM forum_digest WHERE post_id = '$ID' AND last_read_comment_id = '$lastComment'";
$query       = $mysqli->query($sql);
$users       = array();

while ($row = mysqli_fetch_array($query)) {
    $users[] = $row['user_id'];
}

$imploded_users = implode(',', $users);

$query = "SELECT * FROM user_info WHERE smart=1 AND id IN ($imploded_users)";

sendDigest($query, "smartDigest.txt", -.40);
?>