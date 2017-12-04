<?php
include('/home/ubuntu/ECS160WebServer/start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
if(isset($_SESSION['user_id'])){
	$navpath = "../navbar/navbarlogged.html";
    $sessionUser = $_SESSION['user_id'];

}
else{
	$navpath = "../navbar/navbar.html";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Warcraft II-Forum</title>
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
<?php
echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<?php
$friendNotify = false; //variable to check if no notifications
echo"<div class='container div1' id='border-gold'>
	<h1> My Notifications </h1>
	<hr style='height:2px'>
	";
	
	$sqlFriend = "SELECT * from friendlist WHERE request != 0 AND user_id = $sessionUser";
	$queryFriend = $mysqli->query($sqlFriend);
	while ($fetchFriend = $queryFriend->fetch_assoc()) {
		$friendNotify = true;
		$friendId = $fetchFriend['friend_id'];
		$sqlFriendName = "SELECT * from user_info WHERE id = $friendId";
		$queryFriendName = $mysqli->query($sqlFriendName);
		$fetchFriendName = $queryFriendName->fetch_assoc();
		$friendName = $fetchFriendName['username'];
		echo "
			<a href='../messaging/friendslist.php'><div class='div2'><font color = 'white'> You have a new friend request from <b>$friendName</b>.</font></div></a>
		";
	}


//Notifications for forums
    $num = 0;
    $sql = "select * from forum_digest where notifications != 0 AND user_id = $sessionUser";
    $query = $mysqli->query($sql);
    while ($fetch = $query->fetch_assoc()) {
        $postId = $fetch['post_id'];
        $num = $fetch['notifications']; //number of notifications

        $sqlPostName = "select * from post where post_id='$postId'";
        $queryPostName = $mysqli->query($sqlPostName);
        $fetchPostName = $queryPostName->fetch_assoc();
        $postHeader = $fetchPostName['post_header'];
        $postUser = $fetchPostName['user_id'];

        $sqlCommenterName = "select * from comment where post_id='$postId' order by comment_date DESC LIMIT $num";
        $queryCommenterName = $mysqli->query($sqlCommenterName);
        $commenters = array();
        $date = NULL;
        while ($fetchCommenterName = $queryCommenterName->fetch_assoc())
        {   
            if (is_null($date))
            {
                 $date = $fetchCommenterName['comment_date'];
            }
            $oneCommenter = $fetchCommenterName['comment_user'];
            $sqlOneCommenter = "SELECT * from user_info WHERE id = $oneCommenter";
            $queryOneCommenter = $mysqli->query($sqlOneCommenter);
            $fetchOneCommenter = $queryOneCommenter->fetch_assoc();
            $commenters[] = $fetchOneCommenter['username'];
        }
        $commenters = array_unique($commenters);
    
	//use to format the notifications AKA add the and to the list of commenters        
	$commentersString="";
        if(count($commenters) == 1){
            $commentersString = "<b>" . $commenters[0] . "</b>";
        } else {    
            $i = 0;
            while($i < count($commenters) - 1)
            {
                $commentersString = $commentersString . "<b>" .$commenters[$i] . "</b>, ";
                $i = $i +1;
            }
            $commentersString = $commentersString . "and " . "<b>" .$commenters[$i] . "</b>";
        }
        
        
        echo "
			<a href='../forum/comments.php?postId=$postId'><div class='div2'><font color = 'white'>
		";

        if ($postUser == $sessionUser){
            echo "
            $commentersString commented on your post <b>$postHeader</b>. <br>
            <footer>$date</footer>
            ";
        } else {
            echo "
            $commentersString commented on <b>$postHeader</b> since you last viewed the post.
            <footer>$date</footer>
            ";
        }
                
        echo "			
            </font></div></a> 
        ";
    } //ends while loop for forum notifications
    
    if ($friendNotify == false && $num == 0)
    {
        echo "<strong><center><p>Yay you're caught up on notifications!</p></center></strong>";
    }


echo"
</div>
";

?>
</body>
