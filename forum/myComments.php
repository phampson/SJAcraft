<?php

include('/home/ubuntu/ECS160WebServer/start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');

if(isset($_SESSION['user_id'])){
  $navpath = "../navbar/navbarlogged.html";
  $sql = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
      $query = $mysqli->query($sql);
	
  if($query = $mysqli->query($sql)) {
    $fetch = $query->fetch_assoc();
    $username = $fetch['username'];
    $avatarPath = $fetch['avatar_path'];
	$user_id = $fetch['id'];
  }
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
$sql = 'select * from comment'; 

echo "
      <div class='container'>";

  if($query = $mysqli->query($sql)) {
    while ($row = $query->fetch_assoc()) {
      $commentUser = $row['comment_user']; 

      if ($commentUser == $user_id)
      {
	$commentPostId = $row['post_id'];
        $commentContent = $row['comment_content'];
        $postDate = $row['comment_date'];
	
	if($avatarPath == null)
	{
	    $avatarPath = "avatar_pics/profile_default.jpg";
	}

//<a href='comments.php?postId=$commentPostId'>
//</a>
echo "
    <a href='comments.php?postId=$commentPostId'>
       <div class = 'comments' > 
        <div class = 'col-sm-1 Cinfo'>
          <img align=left src='../profile/$avatarPath' alt='Picture' style='width:90px;height:90px;'> <p>$commentUser</p>
        </div> 

        <div class = 'col-sm-9'>
          $commentContent 
        </div>

  	<footer> $postDate </footer>
    
      </div>
  </a> ";

      } 


    }
  }

?>
</body>
</html>

