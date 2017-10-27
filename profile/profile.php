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
		background-image: url("../img/wowDoge.jpg");
		z-index: -999;

	}

	.profilePic{
		position:absolute;
		left: 50px;
		top: 50px;
		float:left;
	}



	.profile username {
		position:absolute;
		top: 30px;
		left: 40%;
		color: white;
		font-size: 40px;


	}
	.userinfo{ 
		position: static;
	}

	.profile email{
		position:absolute;
		top: 90px;
		left: 40%;	
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
		left: 510px;
		top: 250px;
		font-size: 20px;
	}


.box {
  position: absolute;
  top: 35%;
  left: 45%;
  background: white;
  padding: 10px 0px;


  
  text-align: center;
}

.button {
  font-size: 1em;
  width: 10px;
  padding: 10px;
  color: black;
  cursor: pointer;
  
}
.button:hover {
  background: #8c8c8c;
}

.overlay {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0, 0, 0, 0.7);
  transition: opacity 500ms;
  visibility: hidden;
  opacity: 0;
}
.overlay:target {
  visibility: visible;
  opacity: 1;
}

.popup {
  margin: 150px auto;
  padding: 20px;
  background: #fff;
  border-radius: 5px;
  width: 30%;
  position: relative;
}


.popup h2 {
  margin-top: 0;
  color: #333;
  
}
.popup .close {
  position: absolute;
  top: 20px;
  right: 30px;
  transition: all 200ms;
  font-size: 30px;
  font-weight: bold;
  text-decoration: none;
  color: #333;
}
.popup .close:hover {
  color: #999999;
}
.popup .content {
  max-height: 30%;
  overflow: auto;
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
				echo " <form id=\"form\" method=\"post\">
	  			<input type=\"text\" name=\"usrname\"><button  id=\"usr\">Update</button>username<br>
				<input type=\"text\" name=\"firstname\"><button  id=\"\">Update</button>real name<br>
				<input type=\"text\" name=\"firstname\"><button  id=\"\">Update</button>email<br>
				</form> "
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
