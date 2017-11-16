<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");

function getUserMessages($userID)
{
    $host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli2 = new mysqli($host,$username,$userpass,$databasew);
		if ($mysqli2->connect_errno){
		    echo "we have a problem";
		}

    $commentQuery = "SELECT * FROM message WHERE receiver=$userID AND message_date>=DATE_ADD(NOW(), INTERVAL -1 HOUR)";
    $list=$mysqli2->query($commentQuery);
    $msg = "";
    while ($list->fetch_assoc())
    {
        $msg = "You have received a new message";
    }
    mysql_close($mysqli2);
    return $msg;   
}

/*function getUserComment($userID)
{
    $host= "localhost";  //database host
	$username="root";  //database username for log in
	$userpass="ecs160web"; //database password for log in
	$databasew="web"; //database schema name
	$mysqli2 = new mysqli($host,$username,$userpass,$databasew);
	if ($mysqli2->connect_errno){
	    echo "we have a problem";
	}
    $commentQuery = "SELECT * FROM comment WHERE receiver=$userID AND message_date>=DATE_ADD(NOW(), INTERVAL -1 HOUR)";
    $list=$mysqli2->query($commentQuery);
    $msg = "";
    while ($list->fetch_assoc())
    {
        $msg = "You have received a new message";
    }
    mysql_close($mysqli2);
    return $msg;   
}*/

$query = "SELECT * FROM user_info WHERE digest = 1";
$result=$mysqli->query($query);
while ($row = $result->fetch_assoc())
    {
        $Id=$row['id'];
        $msg=getUserMessages($Id);
        //$msg .= getUserComment($Id);
        
        echo $msg;
        
    }

?>
