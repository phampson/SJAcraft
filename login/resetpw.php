<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    // Verify data
    
    $_SESSION['email'] = $email = $mysqli->escape_string($_GET['email']); // Set email variable
    $_SESSION['hash']  = $hash = $mysqli->escape_string($_GET['hash']); // Set hash variable             
    $search            = $mysqli->query("SELECT email, hash FROM user_info WHERE email='" . $email . "' AND hash='" . $hash . "'");
    
    if ($search->num_rows) {
        echo '
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
        <form action="newpw.php" method="post" enctype="multipart/form-data">
                <p1>New Password</p1>
                <input type="password" name="password" placeholder="Enter New Password">
                <div class="text-center">
                    <input type="submit" class="btn btn-fancy-submit" value="">
                    <br><br>
                </div>
        </form>
</div>

</body>
</html>

';
        // We have a match, activate the account
        
        
    } 
    else {
        session_destroy();
        // No match -> invalid url or account has already been activated.
        echo 'The url is either invalid or you already have activated your account.'; // front end please make this prettier
    }
} 
else {
    session_destroy();
    // Invalid approach
    echo 'Invalid approach, please use the link that has been sent to your email.'; // front end please make this prettier
}
?>
