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
	<script src="detectOS.js"></script>
</head>

<body>

<!-- Nav Bar -->
<div id="navbar"></div>
<?php
echo "<script>\n";
	echo '$("#navbar").load("'.$navpath.'")';
echo "</script>\n";
?>

<div class="jumbotron col-xs-12 col-sm-8 col-sm-offset-2" id="banner">
	<h1>Install Warcraft II Tools</h1> 
</div>

<div id = "btmctn" class="container col-xs-12 col-sm-8 col-sm-offset-2" >
    <div class="jumbotron" id="box">
        <div class="container col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-0">
            <img src="../img/tools.png" style="width: 20px; height: auto; float: left; margin-right: 0px;"</img>
            <h1 style="float: right; ">Download tools now!</h1>
        </div>
  
        <div class="button" id="downloadButton">
        </div>
    </div>
</div>

</body>
</html>
