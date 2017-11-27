<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $id    = $_SESSION['user_id'];
    $sql   = "update user_info set web_logged='false' where id=$id";
    $query = $mysqli->query($sql);
}
    
session_destroy();
header("Location: ../index.php");
?>
