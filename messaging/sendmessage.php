<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
$msg = $_POST["msg"];
include('start.php');
$query = 'INSERT INTO message (sender,message_content,receiver,message_date) VALUES ('.(int)$usid.',"'.$msg.'" ,'.(int)$frid.',NOW())';
if($result = $mysqli->query($query))
{
    echo $frid;
}
?>
