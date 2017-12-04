<?php

include('/home/ubuntu/ECS160WebServer/start.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
    $sql     = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query   = $mysqli->query($sql);
    
    if ($query = $mysqli->query($sql)) {
        $fetch      = $query->fetch_assoc();
        $username   = $fetch['username'];
        $avatarPath = $fetch['avatar_path'];
        $user_id    = $fetch['id'];
    }
} 
else {
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

<div class="div1 container col-sm-8 col-sm-offset-2" id="border-gold">
	<h1> My Comments </h1>
	<hr>
	<br>
	<div class="container col-sm-12 col-sm-offset-0">

<?php
$reg_exUrl = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
$reg_attachment = '/attachment_files\/.*/';

if (isset($_SESSION['user_id'])) {
	$sql = 'SELECT * FROM comment';
	if ($query = $mysqli->query($sql)) {
	    while ($row = $query->fetch_assoc()) {
		$commentUser = $row['comment_user'];
		
		if ($commentUser == $user_id) {
		    $commentPostId  = $row['post_id'];
		    $commentContent = $row['comment_content'];
		    $commentDate       = $row['comment_date'];
		    $commentPicPath = "../profile/avatar_pics/$commentUser.jpg";
		    
		    if ($avatarPath == null) {
		        $avatarPath = "avatar_pics/profile_default.jpg";
		    }
		    	
			    $sql2        = 'SELECT * FROM post WHERE post_id = '. $commentPostId;	
			    $query2      = $mysqli->query($sql2);
	 		    	
				if ($mysqli->query($sql2)) {
				    $fetch       = $query2->fetch_assoc();
				    $post_header = $fetch['post_header'];
				    $post_tag    = $fetch['tag'];  
				}

			    $commentQuery2 ="SELECT username FROM user_info WHERE id = '$commentUser' LIMIT 1";
			    if($commentResult = $mysqli->query($commentQuery2)){
				    while ($commentRow = $commentResult->fetch_assoc())
				    {
					    $commentUsername = $commentRow['username'];
				    }
			    } 
		
		    echo "
				<h3> $post_tag &lt;&lt; <a href='comments.php?postId=$commentPostId'>$post_header </a> </h3>
				<a href='comments.php?postId=$commentPostId'>
			   		<div class ='container div2 col-xs-12 col-xs-offset-0'>
				    		<div class = 'col-sm-1 Cinfo'>
								<img align=left src='../profile/$commentPicPath' alt='Warcraft main picture' style='width:90px;height:90px;'>
				    		</div> 
						<div class = 'container col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0'> 
							<font color ='white'>$commentUsername</font>
						</div>
						<div class = 'container col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0'>
			   				<h4>";
							if(preg_match($reg_exUrl, $commentContent, $url)) {
							// make the urls hyper links
							$content=preg_replace($reg_exUrl, '<a href="'.$url[0].'">'.$url[0].'</a>', $commentContent);
							} 
							if(preg_match($reg_attachment, $commentContent, $url)){
								echo preg_replace($reg_attachment, '<a href="'.$url[0].'">'.$url[0].'</a>', $commentContent);
							} else {
							// if no urls in the text just return the text
							echo $commentContent;
							}
						    echo "</h4>
			   			</div>
						<footer>
							<div class = 'container col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0'>
								<font color='white'> $commentDate</font>
							</div>
						</footer>
					</div>
				</a>";
		    
		} // end if
	    } // end while
	} // end if
} // end if

else {
	echo"<script language='javascript'> alert('Please log in'); </script>";
}

?>
	</div>
</div>
</body>
</html>

