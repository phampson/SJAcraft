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
	background: url("../img/Texture.png") repeat;} 

		.profile {
		position:absolute;
		top: 50%;
		left: 50%;
		padding: 40px 40px;
		transform: translate(-50%, -50%);
		width: 1200px;
		height: 500px;
		background: rgba(0,0,0,0.4);
		z-index: -999;

	}

	.profilePic{
		position:absolute;
		left: 50px;
		top: 50px;
		float:left;
	}

.button {
    background-color: #e7e7e7;
    border: none;
    color: black;
    padding: 8px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 18px;
    margin: 4px 10px;
    cursor: pointer;
}



	.profile username {
		position:absolute;
		top: 30px;
		left: 400px;
		color: white;
		font-size: 40px;


	}
	.username{ 
		position: static;
	}

	.profile email{
		position:absolute;
		top: 90px;
		left: 400px;	
		font-size: 18px;
		text-align: center;
		color: white;
		font-size: 35px;
	}
	.email{
		position:static;
	}

	.addFriend {
		position:absolute;
		left: 500px;
		top: 200px;
		font-size: 20px;
	}

	.message {
		position:absolute;
		left: 500px;
		top: 250px;
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



<!-- profile -->
<div class="profile">


	<!--profile picture-->
	<?php
	echo "<div class='profilePic', id='profilePic'>
		 <img src=$avatarPath alt='This is where your profile picture goes' style='width:300px;height:300px;'>";
	?>   
	<form action="upload.php" method="post" enctype="multipart/form-data">
	    <upload> <font color ="white" >Select image to upload:</upload>
	    <input type="file" name="fileToUpload" id="fileToUpload"></font>
	    <input type="submit" value="Upload Image" name="submit">
	</form>

	<?php echo $avatarPath; ?>
	</div>

	
		<username><?php echo $username; ?>Temp bc doesn't work <button class="button username" id="">Change username</button> </username>
		
		<email><?php echo $email; ?>Temp email <button class="button email" id="">Change username</button> </email>
		<button class="button addFriend" id="">Add Friend</button>
		<button class="button message" id="">Message</button>
	
</div>


</body>
</html>
