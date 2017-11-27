<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $sql   = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch      = $query->fetch_assoc();
        $username   = $fetch['username'];
        $email      = $fetch['email'];
        $avatarPath = $fetch['avatar_path'];
        $navpath    = "../navbar/navbarlogged.html";
    }
} 
else {
    $navpath = "../navbar/navbarlogged.html";
}
$password2 = $_POST['password'];
$update    = "UPDATE user_info SET password = '" . $password2 . "' where id = '" . $_SESSION['user_id'] . "'";

if ($mysqli->query($update)) {
    echo "Password changed to: ";
    echo $password2;
}
header('Location: ' . 'profile.php');
?>
