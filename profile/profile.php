<?php

include('start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
	echo $_SESSION['user_id'];
	$sql = 'select * from user_info where username="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);
	if($query) {
		$fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$email = $fetch['email'];
		echo $email;
	}
}
else{
	echo"nothing";
	$username = "username unknown";
	$email = "email unknown";
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
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="../index.html">WarCraft II</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#">About</a></li>
				<li class="">
					<a class="dropdown-toggle" data-toggle="dropdown"href="#">Download
					<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../downloadgame/downloadgame.html">Download the game</a></li>
						<li><a href="../dlc/dlc.php">Download maps</a></li>
					</ul>
				</li>
				<li><a href="../faq/faq.html">FAQ</a></li>
				<li><a href="../forum/forum.html">Forum</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
			</ul>
		</div>
	</div>
</nav>


<!-- gray background -->
<div class="background">

</div>

<!--profile picture-->
<div class="profilePic">
	<img src="profile.jpg" alt="This is where your profile picture goes" style="width:225px;height:228px;">
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
