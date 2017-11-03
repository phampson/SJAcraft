<?php

include('start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();

if(isset($_GET['id'])){
  $sql = "select * from user_info where id=".$_GET['id'];
  $query = $mysqli->query($sql);
  if ($query) {
    $fetch = $query->fetch_assoc();
    $username = $fetch["username"];
    $email = $fetch["email"];
    $avatarPath = $fetch["avatar_path"];
  }
  // if GET[ID] is set, you're trying to view someone else's profile,
  // so grab their info
}
if(isset($_SESSION['user_id'])){
  $navpath = "../navbar/navbarlogged.html";

	$sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);

	if (!isset($_GET['id']) and $query) {
    // if GET[ID] isn't set, view your own profile so grab your own info
    $fetch = $query->fetch_assoc();
    $username = $fetch['username'];
    $email = $fetch['email'];
    $avatarPath = $fetch['avatar_path'];
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

  <!-- This part lets you change profile picture, which should only display
       if $_GET["id"] isn't set, meaning you're viewing your own profile -->
  <?php if(!isset($_GET['id'])): ?>
	<form action="upload.php" method="post" enctype="multipart/form-data">
	    <upload><font color ="white" >Select image to upload:</upload>
	    <input type="file" name="fileToUpload" id="fileToUpload"></font>
	    <input type="submit" value="Upload Image" name="submit">
	</form>
  <?php endif; ?>
  <!-- Aaaand end if -->

	<?php echo $avatarPath; ?>
	</div>

	<userinfo>

		<username><?php echo $username; ?></username>
		<email><?php echo $email; ?></email>

    <!-- This part is what lets you update profile info, and should only show
         if $_GET["id"] isn't set, meaning you're viewing your own profile -->
    <?php if(!isset($_GET['id'])): ?>
		<div class="box">
		<a class="button" href="#popup1" style=background-color: white>Edit info</a>
		</div>

		<div id="popup1" class="overlay">
		<div class="popup">
			<h2>Edit Information</h2>
			<a class="close" href="#">&times;</a>
			<div class="content">
			
		
				<form id="form" action="changeUserInfo.php" method="post">
	  			<input type="text" name="usrname" placeholder= "Username"><button  id="usrname">Update</button><br>
				</form>
				<form id="form" action="changeEmailInfo.php" method="post">
				<input type="text" name="email" placeholder="Email"><button  id="email">Update</button><br>
				</form>
				<form id="form" action="changePasswordInfo.php" method="post">
				<input type="text" name="password" placeholder= "Password"><button  id="password">Update</button><br>
				</form>
    <?php endif; ?>
    <!-- Aaaaand end the if -->
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
