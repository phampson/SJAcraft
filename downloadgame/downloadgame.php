<?php
include('/home/ubuntu/ECS160WebServer/start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
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
		<h1>Install Warcraft II</h1> 
	</div>
	<div id = "reqTable" class="sysreq" >
			<table>
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
			</table>
	`		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			<div id="downloadButton">
				<button src="../img/dldbtn.png"></button>
			</div>
	</div>
</div>

</body>
</html>
