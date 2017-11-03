<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
$msg = $_POST["msg"];
include('/home/ubuntu/ECS160WebServer/start.php');
$query = 'INSERT INTO message (sender,message_content,receiver,message_date) VALUES ('.(int)$usid.',"'.$msg.'" ,'.(int)$frid.',NOW())';
if($result = $mysqli->query($query))
{
    echo $frid;
}
?>
