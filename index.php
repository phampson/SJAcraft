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

<div class="container"
 
     <!-- Banner -->
     <img class="banner" src="img/SplashMirror.png">

     <!-- Logo -->
     <img class="logo" src="img/Logo.png">
     <br>

     <!-- Play Button -->
     <button type="button" class="btn btn-play">Play Now</button>

     <!-- Leader Board -->
     <div class="leaderboard col-sm-8 col-sm-offset-2">
         <h1>Leader Board</h1>
         <h4>1. Parzival</h4>
         <h4>2. Art3mis</h4>
         <h4>3. Aech</h4>
         <h4>4. Daito</h4>
         <h4>5. Shoto</h4>
         <h4>6. IOI-655321</h4>
         <h4>7. IOI-655892</h4>
         <h4>8. IOI-650945</h4>
         <h4>9. IOI-675333</h4>
         <h4>10. IOI-630041</h4>
     </div>
</div>

</body>
</html>
