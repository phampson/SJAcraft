<?php

include('/home/ubuntu/ECS160WebServer/start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
if(isset($_SESSION['user_id'])){
	$navpath = "../navbar/navbarlogged.html";
}
else{
	$navpath = "../navbar/navbar.html";
}

$ID = $_GET['postId'];
// echo "<script>console.log ('PHP Consol: " .$ID. "'); </script>"; 

$sql = 'select * from post where post_id="' .$ID. '"';
	$query = $mysqli->query($sql);
	$fetch = $query->fetch_assoc();
	$header = $fetch['post_header'];
	$user = $fetch['post_user'];
	$content = $fetch['post_content'];
	$date = $fetch['post_date'];
	$tag = $fetch['tag'];

$sql = 'select * from user_info where username="' .$user. '"';
	$query = $mysqli->query($sql);
	$fetch = $query->fetch_assoc();
	$proPic = $fetch['avatar_path'];
//echo "<script>console.log ('PHP Consol: " .$proPic. "'); </script>";


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II-FAQ</title>
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


<div id = "posts" class="container">
  <h1> <?php echo $tag ?> </h1>
  <div class="jumbotron">
   <div class="col-sm-2"> <img align=left src="../profile/<?php echo $proPic ?>" alt="Warcraft main picture" style="width:100px;height:100px;"> <p> <?php echo $user ?>  </p></div>
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
			
			$commentsContent = $row['comment_content'];
			$commentsDate = $row['comment_date'];
echo "
       <div class = 'comments' > 
        <div class = 'col-sm-1 Cinfo'>
          <img align=left src=' default.png ' alt='Warcraft main picture' style='width:90px;height:90px;'> <p>$commentsUser</p>
        </div> 

        <div class = 'col-sm-9'>
          $commentsContent 
        </div>

	<footer> $commentsDate </footer>
    
      </div>";
		}
	    }

	    $result->close();
	}

?>
<!--
  <div class = 'comments' > 
          <div class = 'col-sm-1 Cinfo'>
            <img align=left src=' default.png ' alt='Warcraft main picture' style='width:90px;height:90px;'> <p>Alice</p>
          </div> 

        <div class = 'col-sm-9'>
          You move by clicking on a character and then clicking on a location in your map. 
        </div>

	<footer> DATE </footer>
    
  </div>
-->

    <form id="form" action="uploadComments.php?" method="post">
      <textarea name="comment" placeholder="enter comments "></textarea>
      <input type="hidden" name="ID" value='<?php echo "$ID"; ?>'/>
      <button class="btn-default" onclick="" id="submit">Send</button>
    </form>
</div>




