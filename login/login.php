<?php
//start session and start logout timer
error_reporting(0);
if (!isset($_SESSION)) {
    session_start();
}
$_SESSION['EXPIRES'] = time() + 3600; //Change this value to increase or decrease the logout value
include('start.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = 'select * from user_info where username="' . $username . '" and password="' . $password . '"';
    
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
        $fetch               = $query->fetch_assoc();
        $email_verify        = $fetch['email_verify'];
        $reset_pass          = $fetch['reset_pass'];
        $id                  = $fetch['id'];
        $_SESSION['user_id'] = $fetch['id'];
        if ($email_verify == 0) { //wrong for now for testing. should be ==0
            deliver_response("email not verified");
        } 
        else if ($reset_pass == 1) {
            deliver_response("password not reset");
        } 
        else {
            //echo "Welcome! ";
            //echo $fetch['username'];
            $update = 'update user_info set web_logged="true" where id="' . $id . '"';
            if ($mysqli->query($update)) {
                //header("Location: ../profile/profile.php");
                deliver_response("success");
            }
        }
    }
    else {
        deliver_response("Error: Invalid Username or Password");
    }
} 
else {
    deliver_response("post method crushed");
}

function deliver_response($mess)
{
    $response['message'] = $mess;
    $json_response       = json_encode($response);
    echo $json_response;
}

?>
