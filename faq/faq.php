<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
} 
else {
    $navpath = "../navbar/navbar.html";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II-FAQ</title>
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
<div class="container">
	<h1>FAQ</h1>
	<h2>You Asked, We Answered.</h2>
	<div class="container">
		<div class="panel-group" id="accordion">
		  	<div class="panel panel-default">
		  		<div class="div1 panel-heading">
				    <h3 class="panel-title">
				    	<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				        <font color="white"><center>What is Warcraft II?</center></font></a>
				    </h3>
		    	</div>
		    	<div id="collapse1" class="div2 panel-collapse collapse">
				    <p class="panel-body">Warcraft II: Tides of Darkness is a fantasy-themed real-time strategy (RTS) game published by Blizzard Entertainment and first released for DOS in 1995 and for Mac OS in 1996. Players must collect resources, and produce buildings and units in order to defeat an opponent in combat on the ground, in the air and in some maps at sea. The more advanced combat units are produced at the same buildings as the basic units but also need the assistance of other buildings, or must be produced at buildings that have prerequisite buildings. The majority of the main screen shows the part of the territory on which the player is currently operating, and the minimap can select another location to appear in the larger display. The fog of war completely hides all territory which the player has not explored. Terrain is always visible once revealed, but enemy units remain visible only so long as they stay within a friendly unit's visual radius. (Source: Wikipedia)</p>
			    </div>
	  		</div>
		  	<div class="panel panel-default">
			    <div class="div1 panel-heading">
				    <h3 class="panel-title">
				    	<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
					    <font color="white"><center>Which version of Warcraft II should I download?</center></font></a>
				    </h3>
			    </div>
			    <div id="collapse2" class="div2 panel-collapse collapse">
				    <p class="panel-body">As long as you plan to download the game onto one of its supported platforms (MacOS, Windows, Linux, iOS, or Android), our system detects which platform you are using, and automatically chooses which version is right for your machine! Make sure to check out each platform's requirements on our "Download the Game" page.</p>
			    </div>
		    </div>
		    <div class="panel panel-default">
		   		<div class="div1 panel-heading">
		   			<h3 class="panel-title">
		        		<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
		        		<font color="white"><center>What bugs are in Warcraft II?</center></font></a>
		      		</h3>
		    	</div>
		   		<div id="collapse3" class="div2 panel-collapse collapse">
				    <p class="panel-body">........</p>
		   		</div>
		    </div>
		    <div class="panel panel-default">
		   		<div class="div1 panel-heading">
		   			<h3 class="panel-title">
		        		<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
		        		<font color="white"><center>How do I beat the computer?</center><font></a>
		      		</h3>
		    	</div>
		   		<div id="collapse4" class="div2 panel-collapse collapse">
				    <p class="panel-body">........</p>
		   		</div>
		    </div>
		    <div class="panel panel-default">
		   		<div class="div1 panel-heading">
		   			<h3 class="panel-title">
		        		<a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
		        		<font color="white"><center>What are the shortcut keys?</center></font></a>
		      		</h3>
		    	</div>
		   		<div id="collapse5" class="div2 panel-collapse collapse">
				    <p class="panel-body">........</p>
		   		</div>
		    </div>
		</div>
	</div>
</div>

</body>
</html>
