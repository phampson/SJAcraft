<?php
include('/home/ubuntu/ECS160WebServer/start.php');
$newpassword = $_POST['password'];
$email       = $_SESSION['email'];
$hash        = $_SESSION['hash'];

$check = 'update user_info set password="' . $newpassword . '" where email="' . $email . '" and hash="' . $hash . '"';


if ($mysqli->query($check)) {
    echo "You have successfully reset your password";
} 
else {
    echo "Fail to reset password";
}
?>
