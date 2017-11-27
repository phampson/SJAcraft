<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_SESSION['user_id'])){
	$navpath = "../navbar/navbarlogged.html";
}
else{
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
	echo '$("#navbar").load("'.$navpath.'")';
echo "</script>\n";
?>

<div class="div1 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0" id="border-gold">
	<div class="col-xs-12 col-sm-12 ">
		<h1>Install Warcraft II Tools</h1> 
		<hr>
	</div>

	<div id = "btmctn" class="container col-xs-12 col-sm-12" >
	    <div class="jumbotron div2 container col-xs-12" id="box" ">
	        <div class="container col-xs-12 col-xs-offset-0 col-sm-4 col-sm-offset-0">
	            <img src="../img/tools.png" style="width: 20px; height: auto; float: left; margin-right: 0px;"</img>
	            <h3 style="float: right;">Download tools now!</h3>
	        </div>
	
        	<div class="button container col-sm-2 col-sm-offset-7 col-xs-12 col-xs-offset-0" id="downloadButton">
        		<a href="game_files/ECS160Tools-week4.zip" download="ToolsApp"><button type="button" class="btn btn-fancy-download"></button></a>
       		 </div>
    	</div>
</div>

</body>
</html>
