<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data

    $_SESSION['email'] = $email = $mysqli->escape_string($_GET['email']); // Set email variable
    $_SESSION['hash'] = $hash = $mysqli->escape_string($_GET['hash']); // Set hash variable             
    $search = $mysqli->query("SELECT email, hash FROM user_info WHERE email='".$email."' AND hash='".$hash."'");
                 
    if($search->num_rows){
	echo '
<div class="loginForm">
        <h2>Reset Your password</h2>
        <form action="newpw.php" method="post" enctype="multipart/form-data">
                <p1>New Password</p1>
                <input type="password" name="password" placeholder="Enter New Password">
                <input type="submit" class="button" value="Reset">
        </form>
</div>
';
        // We have a match, activate the account
	

    }else{
	session_destroy();
        // No match -> invalid url or account has already been activated.
        echo 'The url is either invalid or you already have activated your account.'; // front end please make this prettier
    }           
}else{
    session_destroy();
    // Invalid approach
    echo 'Invalid approach, please use the link that has been sent to your email.'; // front end please make this prettier
}
?>
