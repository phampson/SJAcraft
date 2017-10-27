<?php

include('start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
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


<!--background -->
<div class="background">

</div>



<!-- profile -->
<div class="profile">


	<!--profile picture-->
	<?php
	echo "<div class='profilePic', id='profilePic'>
		 <img src=$avatarPath alt='This is where your profile picture goes' style='width:300px;height:300px;'>";
	?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	    <upload><font color ="white" >Select image to upload:</upload>
	    <input type="file" name="fileToUpload" id="fileToUpload"></font>
	    <input type="submit" value="Upload Image" name="submit">
	</form>

	<?php echo $avatarPath; ?>
	</div>

	<userinfo>

		<username><?php echo $username; ?></username>
		<email><?php echo $email; ?>Temp email </email>

		<div class="box">
		<a class="button" href="#popup1" style=background-color: white>Edit info</a>
		</div>

		<div id="popup1" class="overlay">
		<div class="popup">
			<h2>Edit Information</h2>
			<a class="close" href="#">&times;</a>
			<div class="content">
			
		<?php 
		$host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli = new mysqli($host,$username,$userpass,$databasew);

		if ($mysqli->connect_errno){
		    echo "we have a problem";
		}
				echo ' <form id=\"form\" method=\"post\">
	  			<input type=\"text\" name=\"usrname\" placeholder= \"Username\"><button  id=\"usrname\">Update</button><br>
				<input type=\"text\" name=\"firstname\" placeholder= \"Real name\"><button  id=\"firstname\">Update</button><br>
				<input type=\"text\" name=\"email\" placeholder=\"Email\"><button  id=\"email\">Update</button><br>
				</form> ';

		$mysqli->close();
		?> 
			

			</div>
		</div>
		</div>
	</userinfo>

		<!--
	<button class="button addFriend" id="">Add Friend</button>
	<button class="button message" id="">Message</button>
	-->
</div>


</body>
</html>
