<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_SESSION['user_id'])){
	$navpath = "navbar/navbarlogged.html";
}
else{
	$navpath = "navbar/navbar.html";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

<div id="outerctn" class="container col-xs-12 col-xs-offset-0"

     <!-- Banner -->
    <img class="banner" src="img/SplashMirror.png">

     <!-- Logo -->
     <div class="container logoctn col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-4">
        <img class="logo" src="img/Logo.png">
     </div>     
   
    <br>

     <!-- Play Button -->
    <div class="container btnctn col-xs-4 col-xs-offset-4 col-sm-2 col-sm-offset-5">
     <button type="button" class="btn btn-play">Play Now</button>
    </div>

	<!-- Leader Board -->
	<div class="leaderboard container col-xs-12 col-sm-8 col-sm-offset-2">
		<h2 class="text-center">Leader Board</h2>
		<br>
	
		<div class="row">
			<div class="col-xs-3">
				<h4 class="text-right">1.</h4>
			</div>
			<div class="col-xs-8">	
				<div class="media">
					<div class="media-left">
						<img src="./img/default.png" class="media-object" style="width:60px">
					</div>
					<div class="media-body">
						<h4 class="media-heading">Parzival</h4>
						<p>Rank 265</p>
					</div>
				</div>
			</div>
			<div class="col-xs-1">
			</div>
		</div>
		<hr>

		<div class="row">
                        <div class="col-xs-3">
                                <h4 class="text-right">2.</h4>
                        </div>
                        <div class="col-xs-8">
                                <div class="media">
                                        <div class="media-left">
                                                <img src="./img/default.png" class="media-object" style="width:60px">
                                        </div>
                                        <div class="media-body">
                                                <h4 class="media-heading">Art3mis</h4>
                                                <p>Rank 233</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-xs-1">
                        </div>
                </div>
		<hr>

		<div class="row">
                        <div class="col-xs-3">
                                <h4 class="text-right">3.</h4>
                        </div>
                        <div class="col-xs-8">
                                <div class="media">
                                        <div class="media-left">
                                                <img src="./img/default.png" class="media-object" style="width:60px">
                                        </div>
                                        <div class="media-body">
                                                <h4 class="media-heading">Aech</h4>
                                                <p>Rank 220</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-xs-1">
                        </div>
                </div>
		<hr>

		<div class="row">
                        <div class="col-xs-3">
                                <h4 class="text-right">4.</h4>
                        </div>
                        <div class="col-xs-8">
                                <div class="media">
                                        <div class="media-left">
                                                <img src="./img/default.png" class="media-object" style="width:60px">
                                        </div>
                                        <div class="media-body">
                                                <h4 class="media-heading">Daito</h4>
                                                <p>Rank 185</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-xs-1">
                        </div>
                </div>
		<hr>

		<div class="row">
                        <div class="col-xs-3">
                                <h4 class="text-right">5.</h4>
                        </div>
                        <div class="col-xs-8">
                                <div class="media">
                                        <div class="media-left">
                                                <img src="./img/default.png" class="media-object" style="width:60px">
                                        </div>
                                        <div class="media-body">
                                                <h4 class="media-heading">Shoto</h4>
                                                <p>Rank 175</p>
                                        </div>
                                </div>
                        </div>
                        <div class="col-xs-1">
                        </div>
                </div>
		<br>

	</div>
</div>

</body>
</html>
