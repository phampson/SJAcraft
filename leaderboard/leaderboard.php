<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_POST))
{ 
	$sql = 'SELECT username, win, lost, ELO FROM user_info ORDER BY ELO DESC LIMIT 10';
 
        $result=$mysqli->query($sql) or die("project query fail");
        $total = array();
        while ($row = $result->fetch_row()) {
        	$arr = array();
            $arr["name"] = $row[0];
            $arr["win"] = $row[1];
            $arr["lost"] = $row[2];
            $arr["ELO"] = $row[3];
          	array_push($total,$arr);
        }
        echo json_encode($total);
}
else
{
        echo "failed";
}
?>

