<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_POST))
{ 
	if(empty($_POST['order']))
	{
		$order = "lost";
	}
	else {$order = $_POST['order'];}
	$sql = 'SELECT username, win, lost, ELO FROM user_info ORDER BY '.$order.' DESC LIMIT 10';
 
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

