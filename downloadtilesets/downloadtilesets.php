<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if(isset($_SESSION['user_id'])){
    $navpath = "../navbar/navbarlogged.html";
}
else{
    $navpath = "../navbar/navbar.html";
}
?>

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
<div id="navbar"></div>
<?php
echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<!-- CDN gallery -->
<h2 style="color: white; text-align: center;">Tilesets Gallery</h2>

<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<?php
		
		$host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli = new mysqli($host,$username,$userpass,$databasew);
	?>
    </div>
    
<!--<script type = "text/php" src="show_maps.php"></script>-->
		<div class="col-sm-3">
			<!--<div class="thumbnail" onclick="addMap()">-->
				<div class="thumbnail">
				<!--<a href="#"> -->
					
					<img src="../img/maps/plus.jpg" alt="Map1" style="width:100%">
					<div class="caption">
						<form action="upload.php" method="post" enctype="multipart/form-data">
						    Select tileset to upload:
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

