<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
include('start.php');

$test = "sup";

function DisplayMessage($friend_id, $user_id)
{
    global $mysqli;
    $query = 'SELECT * FROM message WHERE (sender = "' . (int) $user_id . '" AND receiver = ' . $friend_id . ') OR (sender = ' . $friend_id . ' AND receiver = "' . (int) $user_id . '")';
    if ($result = $mysqli->query($query)) {
        echo $result->num_rows;
    }
}

DisplayMessage($frid, $usid);
?>
