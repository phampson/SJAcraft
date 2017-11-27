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
$usrname = $_POST['usrname'];
$check   = 'select * from user_info where username="' . $usrname . '"';
$query   = $mysqli->query($check);
$update  = "UPDATE user_info SET username = '" . $usrname . "' where id = '" . $_SESSION['user_id'] . "'";

if ($query->num_rows > 0) {
    echo "Username already taken";
} 
else {
    if ($mysqli->query($update)) {
        echo "Username changed to: ";
        echo $usrname;
    }
}
?>
