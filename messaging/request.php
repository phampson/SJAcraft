<?php
include('start.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
if (isset($_SESSION['user_id']) && isset($_GET['frid'])) {
    $friend_id = $_GET['frid'];
    $action    = $_GET['action'];
    $user_id   = $_SESSION['user_id'];
    $sql       = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query     = $mysqli->query($sql);
    if ($query) {
        $fetch    = $query->fetch_assoc();
        $username = $fetch['username'];
        $navpath  = "../navbar/navbarlogged.html";
    }
} 
else {
    


("Location: ../index.php");
    exit();
}
if ($action == "accept") {
    $accept = "update friendlist set request=0 where user_id=".$user_id." and friend_id=".$friend_id.";";
    if($mysqli->query($accept))
    {echo "I accepted request\n<script type='text/javascript'>history.back();</script>";}
}
elseif ($action == "decline") {
    $decline = "delete from friendlist where user_id=".$user_id." and friend_id=".$friend_id.";delete from friendlist where user_id=".$friend_id." and friend_id=".$user_id.";";
    if($mysqli->multi_query($decline))
    {echo "I decline request\n<script type='text/javascript'>history.back();</script>";}
}
