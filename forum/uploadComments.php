<?php

include('/home/ubuntu/ECS160WebServer/start.php');

$session_user = $_SESSION['user_id'];
if(isset($_SESSION['user_id'])){
    $sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch = $query->fetch_assoc();
        $username = $fetch['username'];
        $email = $fetch['email'];
        $avatarPath = $fetch['avatar_path'];
        $navpath = "../navbar/navbarlogged.html";
	$user_id = $fetch['id'];
    }
}
else {
    $navpath = "../navbar/navbarlogged.html";
}

    $comment = $_POST['comment'];
    $ID = $_POST['ID'];
    $insert = "INSERT into comment (post_id, comment_user, comment_content) values('$ID','$user_id','$comment')";
	
        if($mysqli->query($insert)) {
            echo "Comment uploaded <br>";
	    echo "Redirecting...";
        } else {
		echo"comment NOT uploaded";
	}
	

	$sql = "SELECT comment_id FROM comment WHERE post_id = '$ID' ORDER BY comment_date DESC LIMIT 1; ";
	$query = $mysqli->query($sql);
	$fetch = $query->fetch_assoc();
	$comment_id = $fetch['comment_id'];
	$sql = "UPDATE post SET newest_comment_id = '$comment_id' WHERE post_id = '$ID'";
	
	if($mysqli->query($sql)) {
	}
	else {
		echo "newest_comment_id not added into post table";
	}

	$sql = "select * from forum_digest where user_id='$session_user' AND post_id = '$ID'";
	$query = $mysqli->query($sql);
	if(!mysqli_num_rows($query)) {
		$insert = "INSERT into forum_digest (post_id, user_id, last_read_comment_id) values('$ID','$session_user','$comment_id')";
		$mysqli->query($insert);
		
	}
	else {
		echo "last_read_comment_id not added into forum_digest table";
	}

//header( 'refresh:0;url=comments.php?postId=' . $ID . '');

?>

