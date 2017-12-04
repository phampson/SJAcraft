<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
} else {
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
echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<div class="div1 col-sm-8 col-sm-offset-2 col-xs-12 col-xs-offset-0" id="border-gold" style="padding: 0px;">
	<div class="hdrctnr container col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		<h1>Install Warcraft II</h1>
		<h3>Join the community!</h3>
		<hr>
	</div>

	<div class="container col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0" id="midctnr">
		<div id="carousel" class="carousel slide" data-ride="carousel">
    			<!-- Indicators -->
    			<ol class="carousel-indicators">
	      			<li data-target="#carousel" data-slide-to="0" class="active"></li>
	      			<li data-target="#carousel" data-slide-to="1"></li>
	      			<li data-target="#carousel" data-slide-to="2"></li>
    			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<div class="item active">
					<img src="../img/tower.jpg" alt="Tower" style="width:100%;">
		      		</div>

		      		<div class="item">
					<img src="../img/monster2.jpg" alt="Monster" style="width:100%;">
		      		</div>
		    
		     	 	<div class="item">
					<img src="../img/dragon.jpg" alt="Map" style="width:100%;">
		      		</div>
			</div>

			<!-- Left and right controls -->
			<a class="left carousel-control" href="#carousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#carousel" data-slide="next">
		      		<span class="glyphicon glyphicon-chevron-right"></span>
		      		<span class="sr-only">Next</span>
			</a>
		</div>	
	</div>

	<div class="container col-xs-12 col=xs-offset-0 col-sm-12 col-sm-offset-0" id="btmcntr" style="margin:auto; padding:0px; align: center;">
		<div class="container col-xs-12 col-sm-8 col-sm-offset-2">
			<table id = "reqTable" class="table table-striped" >
				<thread>
					<tr>
						<th>System requirements</th>
						<th>MS-DOS / Windows 3.1 / Windows 95</th>
						<th>Macintosh System 7.5 or higher</th>
					</tr>
					<tr>
						<td>Processor: </td>
						<td>33 MHz 486 or faster</td>
						<td>68040 or PowerPC processor</td>
					</tr>
					<tr>
						<td>RAM:</td>
						<td>8 MB </td>
						<td>8 MB </td>
					</tr>
					<tr>
						<td>Display: </td>
						<td>Super VGA graphics card</td>
						<td>A 13" or better 256-color display</td>
					</tr>
					<tr>
						<td>Hard drive</td>
						<td>Needed</td>
						<td>Needed</td>
					</tr>
					<tr>
						<td>CD-ROM drive:</td>
						<td>Needed (To view the animations from the cd, your CD-ROM drive must be double-speed or faster)</td>
						<td>Needed (To view the animations from the cd, your CD-ROM drive must be double-speed or faster)</td>
					</tr>
				</thread>
			<table>
		</div>

	</div>
		<div class="div" style="position: relative; margin: auto; align: center;" class="container col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0" id="downloadButton">
		</div>
	
</div>

</body>
</html>
