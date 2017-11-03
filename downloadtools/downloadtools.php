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

<div id = "container" class="container">
	<div id = "bannerctnr">
		<h1>Install Warcraft II Tools</h1> 
	</div>
	<div id = "reqTable" class="sysreq" >
	`		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div id="downloadButton">
				<button src="../img/dldbtn.png"></button>
			</div>
	</div>
</div>

</body>
</html>
