<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
} 
else {
    $navpath = "../navbar/navbar.html";
}
?>

<html lang="en">
<head>

	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="stylesheet.css">
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

<div class="div1 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0" id="border-gold">
	<div class="col-xs-12 col-sm-12 ">
		<h1>Install Warcraft II Tools</h1>
		<hr>
	</div>
	
	<div style = "border-radius: 10px; margin:auto; padding:0px;" class="div2 container col-xs-12 col-xs-offset-0">
		<div class="container col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0">
			<center><h3 style="color: white; padding:5px; ">Download tools now!</h3></center>
		</div>
				    			   
		<div style="align: center; position: relative;" class="button container col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0" id="downloadButton">
			<center><a href="../gamefiles/Tools.zip" download="ToolsApp"><button style="margin-bottom:20px;" type="button" class="btn btn-fancy-download"></button></a><center>
		</div>
	</div>

</div>

</body>
</html>
