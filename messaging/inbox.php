<?php
include('start.php');
session_start();
$user   = $_SESSION['user_id'];
$mysqli = new mysqli("localhost", "root", "ecs160web", "web");
if ($mysqli->connect_errno) {
    echo "we have a problem";
}
$query = 'select distinct sender from message where receiver = "' . $user . '" order by data';
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        echo $row['sender'];
    }
} else {
    echo "error";
}
?>
