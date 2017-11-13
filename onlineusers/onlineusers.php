<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if(isset($_SESSION['user_id'])){
  $navpath = "../navbar/navbarlogged.html";
	$sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);
	if (!isset($_GET['id']) and $query) {
    // if GET[ID] isn't set, view your own profile so grab your own info
    $fetch = $query->fetch_assoc();
    $username = $fetch['username'];
    $email = $fetch['email'];
    $avatarPath = $fetch['avatar_path'];
	}
}
else {
	$navpath = "../navbar/navbar.html";
    //header('Location: ' . '../login/login.html');
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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

<!-- Tabs -->
<div class="container col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 transparent-background">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#web">Web</a></li>
		<li><a data-toggle="tab" href="#game">Game</a></li>
	</ul>

	<div class="tab-content">
		<div id="web" class="tab-pane fade in active">
			<h1>Online Users</h1>
			<div id="new_user_container_web"></div>
		</div>
		<div id="game" class="tab-pane fade">
			<h1>Online Users</h1>
                        <div id="new_user_container_game"></div>
		</div>
	</div>
</div>

</body>
<script src="onlineusers.js"></script>
</html>
