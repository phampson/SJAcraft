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
$email2 = $_POST['email'];
$check  = 'select * from user_info where email="' . $email2 . '"';
$query  = $mysqli->query($check);
$update = "UPDATE user_info SET email = '" . $email2 . "' where id = '" . $_SESSION['user_id'] . "'";


//if a form's text box isn't empty, then update
if ($_POST['usrname'] != "") {
    include 'changeUserInfo.php';
}

if ($_POST['password'] != "") {
    include 'changePasswordInfo.php';
}

if ($_POST['email'] != "") {
    include 'changeEmailInfo.php';
}

if ($_POST['digest'] != -1) {
    $insert = "UPDATE user_info SET digest = '" . $_POST['digest'] . "' where id = '" . $_SESSION['user_id'] . "'";
    $mysqli->query($insert);
}

if ($_POST['smart'] != -1) {
    $insert = "UPDATE user_info SET smart = '" . $_POST['smart'] . "' where id = '" . $_SESSION['user_id'] . "'";
    $mysqli->query($insert);
}

header('Location: ' . 'profile.php');
?>
