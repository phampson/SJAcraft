<?php
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
$sql = 'select * from post';



if ($query = $mysqli->query($sql)) {
    while ($row = $query->fetch_assoc()) {
        $postUser = $row['user_id'];
        
        if ($postUser == $user_id) {
            $postId      = $row['post_id'];
            $postHeader  = $row['post_header'];
            $postContent = $row['post_content'];
            $postDate    = $row['post_date'];
            
            echo "
				<div class='container'>
				<a href='comments.php?postId=$postId'>
				<div class='jumbotron'>
					<div class='col-sm-2'> <img align=left src='../profile/$avatarPath' alt='Warcraft main picture' style='width:100px;height:100px;'> <p>$postUser</p></div>
					<h3> $postHeader</h3>
					<p> $postContent </p>
					<footer> $postDate </footer>
				</div>
			</a> 
			</div>";
            
        }
        
    }
}

?>
</body>
</html>
