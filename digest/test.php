<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");

function getUserMessages($userID)
{
    $mysqli = $GLOBALS["mysqli"];

    $commentQuery = "SELECT * FROM message WHERE receiver=$userID AND message_date>=DATE_ADD(NOW(), INTERVAL -5 HOUR)";
    $list=$mysqli->query($commentQuery);
    while ($row = $list->fetch_assoc())
    {
        echo $row['receiver'];
    }
    //return $mysqli->query($commentQuery) or die(mysqli_error($mysqli)); 
    return $mysqli->query($commentQuery) or die(mysqli_error($mysqli));   
}

if($list = getuserMessages(66)) {
    echo "We got something!";
}
?>
