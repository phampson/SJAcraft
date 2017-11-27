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
        echo 'Your account has been activated, you can now login';
        // front end please echo some HTML to make this prettier
    } 
    else {
        // No match -> invalid url or account has already been activated.
        echo 'The url is either invalid or you already have activated your account.';
        // front end please make this prettier
    }
} 
else {
    // Invalid approach
    echo 'Invalid approach, please use the link that has been sent to your email.';
    // front end please make this prettier
}
?>
