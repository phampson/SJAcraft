<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
$msg  = $_POST["msg"];
include('/home/ubuntu/ECS160WebServer/start.php');
$query = 'INSERT INTO message (sender,message_content,receiver,message_date) VALUES (' . (int) $usid . ',"' . $msg . '" ,' . (int) $frid . ',NOW())';
function update_newestmsg($user_id, $friend_id, $mysqli)
{
    $message_sql   = 'select * from message where (sender=' . $user_id . ' and receiver=' . $friend_id . ') or (sender=' . $friend_id . ' and receiver = ' . $user_id . ') ORDER BY message_date DESC';
    $message_query = $mysqli->query($message_sql);
    if ($newest_msg = $message_query->fetch_assoc()) {
        $newest_msgid      = $newest_msg['message_id'];
        $update_newest_sql = 'update friendlist set interact_msgid=' . $newest_msgid . ',newest_msgid=' . $newest_msgid . ' where user_id=' . $user_id . ' and friend_id=' . $friend_id . ';update friendlist set newest_msgid=' . $newest_msgid . ' where user_id=' . $friend_id . ' and friend_id=' . $user_id . ';';
        $mysqli->multi_query($update_newest_sql);
    }
}
if ($result = $mysqli->query($query)) {
    update_newestmsg($usid, $frid, $mysqli);
    echo $frid;
}
?>
