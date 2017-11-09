<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_SESSION['user_id'])){
    $sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch = $query->fetch_assoc();
        $username = $fetch['username'];
        $email = $fetch['email'];
        $avatarPath = $fetch['avatar_path'];
        $navpath = "../navbar/navbarlogged.html";    
    }
}
else {
    $navpath = "../navbar/navbarlogged.html";
}

    $comment = $_POST['comment'];
    $ID = $_POST['ID'];
    $insert = 'INSERT into comment (post_id, comment_user, comment_content, comment_date) values(' . $ID . ', "' . $username . '", "' . $comment . '", NOW() + INTERVAL 16 HOUR)';

        if($mysqli->query($insert)) {
            echo "Comment uploaded <br>";
	    echo "Redirecting...";
        } else {
		echo"comment NOT uploaded";
	}

header( 'refresh:3;url=comments.php?postId=' . $ID . '');



?>

