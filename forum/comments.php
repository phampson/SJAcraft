<?php

include('/home/ubuntu/ECS160WebServer/start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');

if(isset($_SESSION['user_id'])){
    $session_user = $_SESSION['user_id'];
	$navpath = "../navbar/navbarlogged.html";
}
else{
	$navpath = "../navbar/navbar.html";
}
?>
<?php
// Helper function
function phpConsole($data) {
    $output = $data;
    if (is_array($output))
        $output = implode( ',', $output);

    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php

$ID = $_GET['postId'];
 

$sql = 'select * from post where post_id="' .$ID. '"';
	$query = $mysqli->query($sql);
	$fetch = $query->fetch_assoc();
	$header = $fetch['post_header'];
	$user = $fetch['user_id'];
	$content = $fetch['post_content'];
	$date = $fetch['post_date'];
	$tag = $fetch['tag'];
	$newest_comment_id= $fetch['newest_comment_id'];

$sql = 'select * from user_info where id="' .$user. '"';
	$query = $mysqli->query($sql);
	$fetch = $query->fetch_assoc();
	$proPic = $fetch['avatar_path'];
	$post_user_id = $fetch['id'];
	$username = $fetch['username'];

if(isset($_SESSION['user_id'])){
    $sql = "UPDATE forum_digest SET last_read_comment_id = '$newest_comment_id' WHERE post_id = '$ID' AND user_id = '$session_user'";
    $mysqli->query($sql);
}
//echo "<script>console.log ('PHP Consol: " .$proPic. "'); </script>";


?>


<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
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


<div id = "posts" class="container">
  <h1 style="color:white;"> <?php echo $tag ?> </h1>
  <div class="jumbotron">
   <div class="col-sm-2"> <img align=left src="../profile/<?php echo $proPic ?>" alt="Warcraft main picture" style="width:100px;height:100px;"> <a href="../profile/profile.php?id=<?php echo $post_user_id?>"> <?php echo $username ?>  </a></div>
      <h3> <?php echo $header ?> </h3>
      <p> <?php echo $content ?> </p>
      <footer> <?php echo $date ?></footer>
  </div> 

<?php
	$query = "select * from comment";

		
	if ($result = $mysqli->query($query)) {
	    while ($row = $result->fetch_assoc()) {
		$commentsPostId = $row['post_id'];
		if ($ID == $commentsPostId)
		{
			$commentsUser = $row['comment_user'];
			

			$commentQuery ="SELECT avatar_path FROM user_info WHERE id = '$commentsUser' LIMIT 1";
			$commentQuery2 ="SELECT username FROM user_info WHERE id = '$commentsUser' LIMIT 1";

			$host= "localhost";
			$username="root";
			$userpass="ecs160web";
			$databasew="web";
			$commentSqli = new mysqli($host,$username,$userpass,$databasew);
			if ($commentSqli->connect_errno){
			    echo "Error connecting to Database";
			    exit;
			}

			$commentPicPath = "../profile/avatar_pics/$commentsUser.jpg";
			$commentUsername = "username";
			if($commentResult = $commentSqli->query($commentQuery)){
				while ($commentRow = $commentResult->fetch_assoc())
				{
					$commentPicPath = $commentRow['avatar_path'];
				}
			} 
			if($commentResult = $commentSqli->query($commentQuery2)){
				while ($commentRow = $commentResult->fetch_assoc())
				{
					$commentUsername = $commentRow['username'];
				}
			} 
			$commentSqli->close();
	
			$commentsContent = $row['comment_content'];
			$commentsDate = $row['comment_date'];
echo "
       <div class = 'comments' > 
        <div class = 'col-sm-1 Cinfo'>
          <img align=left src='../profile/$commentPicPath' alt='Picture' style='width:90px;height:90px;'> <p>$commentsDate</p>
        </div> 

        <div class = 'col-sm-9'>
          <a href='../profile/profile.php?id=$commentsUser'> $commentUsername </a> 
        </div>
        

	<div class = 'col-sm-11'>
          $commentsContent
        </div>
    
      </div>";
		}
	    }

	}



if(isset($_SESSION['user_id'])){
	echo "<form id='form' action='uploadComments.php?' method='post'>
      <textarea name='comment' placeholder='enter comments'></textarea>
      <input type='hidden' name='ID' value='$ID'/>
      <button class='btn-default' onclick='' id='submit'>Send</button>
    </form>";
}

?>
<!--
    <form id="form" action="uploadComments.php?" method="post">
      <textarea name="comment" placeholder="enter comments"></textarea>
      <input type="hidden" name="ID" value='<?php echo "$ID"; ?>'/>
      <button class="btn-default" onclick="" id="submit">Send</button>
    </form>
-->
</div>




