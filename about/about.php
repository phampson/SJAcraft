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
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<link rel="stylesheet" href="stylesheet.css">
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

<div class="transparent-background">
	<img align= left src="../img/warcraft.jpg" alt="Warcraft main picture" style="width:100px;height:125px;">
	<b><h2>Introduction</h2></b>
	<p1>Ever since the fall of Azeroth in the First war against the Orc from their homeworld Draenor, the humans of Azeroth have been forced into nearby kingdom of Lordaeron. Together with the elves and Dwarves, the humans formed the Alliance to fight against the Orc who have now set their sights on Lordaeron. You, a human, must defend the kingdom of Lordaeron.</p1>
</div>


<div class="transparent-background">
	<b><h2>How to play</h2></b>
	<p1>You must collect resources by using your tools on the bottom left corner and then clicking on a resourse. You can also make your buildings and units by clicking on the hammer icon, clicking the type of building and placing it on the map. Once you are done, explore unknonwn territory to find your enemies and unleash your units on the enemy buildings. When all the buildings and units are gone from a side, a victor is declared!</p1>
</div>

</body>
</html>
