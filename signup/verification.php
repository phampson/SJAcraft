<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    
    $email = $mysqli->escape_string($_GET['email']); // Set email variable
    $hash  = $mysqli->escape_string($_GET['hash']); // Set hash variable
    
    $search = $mysqli->query("SELECT email, hash, email_verify FROM user_info WHERE email='" . $email . "' AND hash='" . $hash . "' AND email_verify='0'");
    
    if ($search->num_rows) {
        // We have a match, activate the account
        $mysqli->query("UPDATE user_info SET email_verify='1' WHERE email='" . $email . "' AND hash='" . $hash . "' AND email_verify='0'") or die(mysql_error());
        $emailmsg = 'Your account has been activated, you can now login';
        // front end please echo some HTML to make this prettier
    } 
    else {
        // No match -> invalid url or account has already been activated.
        $emailmsg = 'The url is either invalid or you already have activated your account.';
        // front end please make this prettier
    }
} 
else {
    // Invalid approach
    $emailmsg = 'Invalid approach, please use the link that has been sent to your email.';
    // front end please make this prettier
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
        <h1 class="text-center">Email Verification</h1>
        <p><?php echo $emailmsg ?></p>
</div>

</body>
</html>
