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
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
<!-- CSS Styling -->
<style>
	html, body {
	background: url("img/texture.png") repeat;} 

	.profile {
		position:absolute;
		top: 54%;
		left: 50%;
		padding: 70px 40px;
		transform: translate(-50%, -50%);
		width: 1200px;
		height: 500px;
		background: rgba(0,0,0,0.4);
		z-index: -999;
	}

	.profilePic{
		position:relative;
		left: 100px;
		top: 50px;
		float:left;
	}

	.profile username {
		position:relative;
		left: 320px;
		top: 0px;
		color: white;
		font-size: 40px;
	}

	.profile rank {
		position:relative;
		left: 70px;
		top: 30px;
		color: gray;
		font-size: 30px;
	}

	.profile status{
		position:absolute;
		top: 45%;
		left: 45%;
		transform: translate(-50%, -50%);
		width: 350px;
		height: 80px;
		background: rgba(220, 220, 171, 0.74);
		font-size: 18px;
		text-align: center;
	}

	.profile addFriend {
		position:relative;
		left: -170px;
		top: 200px;
		color: gray;
		font-size: 20px;
	}

	.profile addFriend2 {
		position:relative;
		left: 320px;
		top: 200px;
		color: gray;
		font-size: 20px;
	}


</style>

<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>


<!-- gray background -->
<div class="background">

</div>

<!--profile picture-->
<?php
echo "<div class='profilePic', id='profilePic'>
	 <img src=$avatarPath alt='This is where your profile picture goes' style='width:225px;height:228px;'>";
?>   
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php echo $avatarPath; ?>
</div>

<!-- profile -->
<div class="profile">

	<username><?php echo $username; ?></username>
   
	<rank> Level 100 mage </rank>
	<status><?php echo $email; ?></status>
	<addFriend> <a href="#">Add Friend</a><br> </addFriend>
	<addFriend2> <a href="#">Message</a> </addFriend2>
</div>


</body>
</html>
