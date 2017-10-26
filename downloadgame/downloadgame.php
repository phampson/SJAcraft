<?php
include('../login/start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
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
	<link rel="stylesheet" href="stylesheet.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<script type="text/javascript">
	$(document).ready(function (){
		findOS();
	});
var operatingSystem = "Unknown";
var appVer = "";
var mobileOS = "";
var isMobileOS = false;
function findOS() 
{
    isMobile();
    if (isMobileOS) {
        operatingSystem = mobileOS;
    } else {
        appVer = navigator.appVersion;
        switch(appVer != "") {
            case (appVer.indexOf("Win")!=-1):
                //operatingSystem = "Windows";
		operatingSystem = 0;
                break;
            case (appVer.indexOf("Mac")!=-1):
                //operatingSystem = "MacOS";
		operatingSystem = 1;
                break;
            case (appVer.indexOf("X11")!=-1):
                //operatingSystem = "UNIX";
		operatingSystem = 2;                
		break;
            case (appVer.indexOf("Linux")!=-1):
                //operatingSystem = "Linux";
		operatingSystem = 3;
                break;      
        }       
    }
	switch(operatingSystem != -9) {
		case(operatingSystem == 0):
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 1):
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 2):
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
		case(operatingSystem == 3):
			document.getElementById("downloadButton").innerHTML = '<a href="game_files/ECS160Linux-master.zip" download><img border="0" src="../img/dldbtn.png"></img></a>';
			break;
	}
}
function isMobile()
{
    if(navigator.userAgent.match(/Android/i)) {
        isMobileOS = true;
        mobileOS = "Android";
    } else if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
        isMobileOS = true;
        mobileOS = "iOS";
    }
}
</script>
<!-- Nav Bar -->
<div id="navbar"></div>
<?php
echo "<script>\n";
	echo '$("#navbar").load("'.$navpath.'")';
echo "</script>\n";
?>
<div id="downloadButton"></div>
<div id = "container" class="container">
	<div id = "bannerctnr">
		<h1>Install World of Warcraft</h1> 
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
			
	</div>
</div>

</body>
</html>
