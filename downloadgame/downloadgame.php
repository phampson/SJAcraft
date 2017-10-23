<?php

include('../login/start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
	echo $_SESSION['user_id'];
	$sql = 'select * from user_info where username="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);
	if($query) {
		$fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$email = $fetch['email'];
		$avatarPath = $fetch['avatar_path'];
		echo $email;
		$navpath = "../navbar/navbarlogged.html";
	}
}
else{
	echo"nothing";
	$username = "username unknown";
	$email = "email unknown";
	$navpath = "../navbar/navbar.html";
	echo "\n" . $navpath;
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

<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<div class="sysreq">
	<h1>From Blizzard support:</h1>
	<h1>System requirements</h1>
		<h2>MS-DOS / Windows 3.1 / Windows 95:</h2>
			<h3>- 33 MHz 486 or faster</h3>
			<h3>- 8 MB of RAM</h3>
			<h3>- Super VGA graphics card</h3>
			<h3>- Hard drive</h3>
			<h3>- CD-ROM drive (To view the animations from the cd, your CD-ROM drive must be double-speed or faster)</h3>

		<h2>Macintosh System 7.5 or higher:</h2>
			<h3>- 68040 or PowerPC processor</h3>
			<h3>- 8 MB of RAM</h3>
			<h3>- A 13" or better 256-color display</h3>
			<h3>- Hard drive</h3>
			<h3>- CD-ROM drive (To view the animations from the cd, your CD-ROM drive must be double-speed or faster)</h3>
</div>

<div class="moresysreq">
	<h1>System requirements at launch:</h1>
		<h2>PC requirements:</h2>
			<h3>Computer: Warcraft II requires a 100% IBM PC compatible computer, with a 486/33 MHz or better processor and at least 8 megabytes of memory.</h3>
			<h3>Operation System: You may play Warcraft II under MS-DOS version 5.0 or higher, Windows 95, or Windows 3.1.</h3>
			<h3>Controls: A keyboard and a 100% Microsoft-compatible mouse are required.</h3>
			<h3>Disk Drives: A hard drive and CD-ROM drive are required to play Warcraft II. To view the animations from the CD, your CD-ROM drive must be double-speed or faster. Blizzard strongly recommends that you do not run Warcraft II from a compressed drive.</h3>
			<h3>Video: Warcraft II requires a VESA 1.2 or higher compatible SuperVGA card.</h3>
			<h3>Sound: Warcraft II supports Sound Blaster, General MIDI, Pro Audio Spectrum, Gravis Ultrasound, Microsoft Sound System, and 100% compatible cards. To play CD-quality music during the game, both your sound card and your CD-ROM drive must be configured for playing Redbook Audio.</h3>


		<h2>Macintosh requirements:</h2>
			<h3>Computer: Warcraft II requires a Macintosh with a 68040 or PowerPC processor and 8 megs of physical RAM. Running with Virtual Memory enabled can decrease game performance.</h3>
			<h3>Operating System: Warcraft II requires System 7.5 or higher.</h3>
			<h3>Controls: A keyboard and a mouse are required. If you own a two button mouse, please consult your mouse manual for instructions on configuring the second button to simulate a command (cmd) click.</h3>
			<h3>Disk Drives: A hard drive and CD-ROM drive are required to play Warcraft II. To view animations from the CD, your CD-ROM drive must be double-speed or faster.</h3>
			<h3>Video: Warcraft II requires a 13" or better 256-color display.</h3>
			<h3>Sound: Music is played straight from the Warcraft II CD.</h3>
	</h1>
</div>

<h4>All Credits to go to Gamepedia, Curse Inc.</h4>

</body>
</html>
