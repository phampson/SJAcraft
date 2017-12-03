<?php
// Jon's alternate homepage design

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
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

<div class="bg">
    <div class="text-center" style="position: absolute; left: 0; top: 25%; width: 100%;">
        <iframe width="1080" height="730" src="https://gaming.youtube.com/embed/live_stream?channel=UCi7DlpxNLFJGp0LfO7Qclsg" frameborder="0" allowfullscreen></ifram>
    </div>
</div>
</body>
</html>
