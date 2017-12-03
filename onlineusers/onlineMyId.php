<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_POST['user_type'])) {
    $arr = array();
    if (isset($_SESSION['user_id'])) {
        $arr[] = $_SESSION['user_id'];
    }
    else {
        $arr[] = -1;
    }
    echo json_encode($arr);
} 
else {
    echo "failed";
}
?>
