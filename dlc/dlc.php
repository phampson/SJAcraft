<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

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
				<li><a href="index.html">About</a></li>
				<li class="dropdown active">
					<a class="dropdown-toggle" data-toggle="dropdown"href="#">Download
					<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Download the game</a></li>
						<li><a href="#">Download maps</a></li>
					</ul>
				</li>
				<li><a href="#">FAQ</a></li>
				<li><a href="#">Forum</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"> Sign Up</a></li>
				<li><a href="../login/login.html"><span class="glyphicon glyphicon-user"></span> Log In</a></li>
			</ul>
		</div>
	</div>
</nav>

<!-- CDN gallery -->
<h2 style="color: white; text-align: center;">Map Gallery</h2>

<div class="col-sm-8 col-sm-offset-2">


		<?php
		
		$host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli = new mysqli($host,$username,$userpass,$databasew);

		if ($mysqli->connect_errno){
		    echo "we have a problem";
		}

		$query = "select * from map";
		
		if ($result = $mysqli->query($query)) {
			$count = 0;
		    while ($row = $result->fetch_assoc()) {
			if($count % 4 == 0){
				echo "<div class='row'>";		
			}
			$map_path = $row['map_path'];
			$map_name = $row['map_name'];
			$map_thumbnail = $row['map_thumbnail'];
			echo "
		<div class='col-sm-3'>
			<div class='thumbnail'>
				<a href=$map_path download>
					<img src=$map_thumbnail alt='Map1' style='width:100%'>
					<div class='caption'>
						<p>$map_name</p>
						 <p>2 - 4 players</p>
					</div>
				</a>
			</div>
		</div>";
			if($count % 4 == 3){
				echo "</div>";		
			}
			$count = $count + 1;
		    }

		    $result->close();
		}
		?>
		<!--<script type = "text/php" src="show_maps.php"></script>-->
		<div class="col-sm-3">
			<!--<div class="thumbnail" onclick="addMap()">-->
				<div class="thumbnail">
				<!--<a href="#"> -->
					
					<img src="../img/maps/plus.jpg" alt="Map1" style="width:100%">
					<div class="caption">
						<form action="upload.php" method="post" enctype="multipart/form-data">
						    Select map to upload:
						    <input type="file" name="fileToUpload" id="fileToUpload"> 
						    <input type="submit" value="Upload Image" name="submit">
					</form>
					</div>
				</a>
			</div>
		</div>
	</div>


</body>
<script type="text/javascript" src="cdn.js"></script>
</html>
