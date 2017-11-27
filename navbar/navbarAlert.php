<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $userid = $_SESSION['user_id'];
    
    $query = 'select * from friendlist where interact_msgid!=newest_msgid and user_id = "' . $userid . '"';
    if ($result = $mysqli->query($query)) {
        if ($result->num_rows > 0) {
            echo 'true';
        } 
        else {
            echo 'false';
        }
    }
}
?>
