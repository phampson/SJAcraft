<?php
include('/home/ubuntu/ECS160WebServer/start.php');

$newpassword = $_POST['password'];
$email       = "";
$hash        = "";

if (isset($_SESSION['email'])) {
    $email       = $_SESSION['email'];
}
if (isset($_SESSION['hash'])) {
    $hash        = $_SESSION['hash'];
}

$check = 'update user_info set password="' . $newpassword . '" where email="' . $email . '" and hash="' . $hash . '"';


if ($mysqli->query($check)) {
    $pwmsg =  "You have successfully reset your password";
} 
else {
    $pwmsg =  "Fail to reset password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
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
<script>
        $("#navbar").load("../navbar/navbar.html")
</script>

<!-- Login form -->
<div class="div1 col-xs-12 col-sm-6 col-sm-offset-3" id="border-gold">
        <h1 class="text-center">Reset Password</h1>
        <p><?php echo $pwmsg ?></p>
</div>

</body>
</html>
