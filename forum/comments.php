<?php
include('/home/ubuntu/ECS160WebServer/start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
if(isset($_SESSION['user_id'])){
	$session_user = $_SESSION['user_id'];
	$ID = $_GET['postId'];
	$navpath = "../navbar/navbarlogged.html";
	
	// update all logged in user's forum_digest table so that all their subscribed posts's last_read_comment is the the newest_comment_id of that post
	$get_subscribed_posts = "SELECT * FROM forum_digest WHERE user_id = $session_user";
	$subscribed_posts = $mysqli->query($get_subscribed_posts) or die("Failed to retrieve posts from database.");

	while ($row = $subscribed_posts->fetch_assoc()) {
		$post_id = $row["post_id"];
		$get_newest_com = "SELECT newest_comment_id FROM post WHERE post_id = $post_id";
		$newest_com = $mysqli->query($get_newest_com);
		$fetch = $newest_com->fetch_assoc();
		if ($fetch['newest_comment_id']) {
			$newest_com = $fetch['newest_comment_id'];
			$update_last_read = "UPDATE forum_digest SET last_read_comment_id = $newest_com WHERE post_id = $post_id AND user_id = $session_user";
		$mysqli->query($update_last_read);
		}
	}
    
    // update notification column in forum_digest
	$update_notification = "UPDATE forum_digest SET notifications = 0 WHERE user_id = $session_user AND post_id = $ID";
	$mysqli->query($update_notification);

    //echo json_encode($subscribed_posts);

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
$reg_exUrl = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
$reg_attachment = '/attachment_files\/.*/';
 
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

<div id = "posts" class="container col-sm-12 col-xs-12">
	<h3> <?php echo $tag ?> </h3>
	<a href="forum.php">
  		<h4 style="color:white;"> &lt&lt Go back to Forums</h4>
	</a>
  	<hr><br>

    <div class="container div1">
    <br>
      	<div class="jumbotron div2 col-xs-12 col-xs-offset-0">
            <br>
		    <div class= "col-sm-1">
                <a href="../profile/profile.php?id=<?php echo $post_user_id ?>">
       			<img align=left src="../profile/<?php echo $proPic ?>" alt="Warcraft main picture" style="width:100px;height:100px;">
			    <p><?php echo $username ?><p></a>
		    </div>
		    <div class = "col-sm-10 col-xs-10 col-xs-offset-1">
        			    <h2> <?php echo $header ?> </h2>
				        <h4> <?php 
                        if(preg_match($reg_exUrl, $content, $url)) {
                        // make the urls hyper links
                        $content=preg_replace($reg_exUrl, '<a href="'.$url[0].'">'.$url[0].'</a>', $content);
                        }
                        if(preg_match($reg_attachment, $content, $url)){
                        // if no urls in the text just return the text
                        echo preg_replace($reg_attachment, '<a href="'.$url[0].'">'.$url[0].'</a>', $content);
                        } else {
                        echo $content;
                        }?></h4>
                        <p><footer><font color="white"><?php echo $date?></font></footer></p>
      		</div>
	    </div> <!--ends jumbotron-->

	    <div class="container col-sm-10 col-sm-offset-1">
		    <h3 style="color: white; margin-left: 20px;"> Comments </h3>
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
           		<div class ='div2' > 
            		<div class = 'col-sm-1 Cinfo'>
                        <a href='../profile/profile.php?id=$commentsUser'>              			
                        <img align=left src='../profile/$commentPicPath' alt='Picture' style='width:90px;height:90px;'>
                        <font color ='white'>$commentUsername</font> 
                        </a>
            		</div> 

			        <div class = 'col-sm-10 col-sm-offset-1'>
           				<h4 style='word-wrap: break-word;'>";
                        if(preg_match($reg_exUrl, $commentsContent, $url)) {
                        // make the urls hyper links
                        $content=preg_replace($reg_exUrl, '<a href="'.$url[0].'">'.$url[0].'</a>', $commentsContent);
                        } 
                        if(preg_match($reg_attachment, $commentsContent, $url)){
	                        echo preg_replace($reg_attachment, '<a href="'.$url[0].'">'.$url[0].'</a>', $commentsContent);
                        } else {
                        // if no urls in the text just return the text
                        echo $commentsContent;
                        }
                    echo "</h4>
           			</div>
                    <footer><div class = 'col-sm-10 col-sm-offset-1'>
                        <font color='white'> $commentsDate</font>
                    <div></footer>
		        </div>";
				    } //end if
	        		} //end while
		    }//end if
    if(isset($_SESSION['user_id'])){
	    echo "<form id='form' action='uploadComments.php?' method='post'>
          <textarea id='commentcontent' name='comment' placeholder='enter comments' required></textarea>
          <input type='hidden' name='ID' value='$ID'/>
          <input type='file' name='fileToUpload' id='fileToUpload'>
          <input type='button' class = 'btn-simple' id='upJQuery' value='upload'><br>
          <button class='btn-simple' onclick='' id='submit'>Send</button>
        </form>
    <script>
    $('#upJQuery').on('click', function() {
     var fd = new FormData();
     fd.append('upload', 1);
     fd.append('fileToUpload', $('#fileToUpload').get(0).files[0]);
     $.ajax({
     url: 'Forumattachment.php',
     type: 'POST',
     processData: false,
     contentType: false,
     data: fd,
     success: function(d) {
     if (d.indexOf('Error') <0){
     $('#fileToUpload').val('');
     document.getElementById('commentcontent').value +='\\n'+d+'\\n';
     }
     else {alert('Cannot Upload');}
     }
     });
    });
    </script>";
    }
    ?>
    </div>
	</div>
</div>
</body>
