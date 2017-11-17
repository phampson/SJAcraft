<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_POST))
{ 
	$sql = 'SELECT ELO, username FROM user_info ORDER BY ELO LIMIT 10';
 
        $result=$mysqli->query($sql) or die("project query fail");
        $arr = array();
        while ($row = $result->fetch_row()) {
            $arr[$row[1]] = $row[0];
        }
        echo json_encode($arr);
}
else
{
        echo "failed";
}
?>

