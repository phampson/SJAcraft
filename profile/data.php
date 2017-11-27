<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_POST))
{ 	
	$sql = 'SELECT username, id, win, lost FROM user_info';
 
        $result=$mysqli->query($sql) or die("project query fail");
        $values = array();
        while ($row = $result->fetch_row()) {
        	$arr = array();
        	$arr["username"] = $row[0];
            $arr["id"] = $row[1];
            $arr["win"] = $row[2];
            $arr["lost"] = $row[3];
          	array_push($values,$arr);
          	
        }
        
        $keys1 = array("username","id","win","lost");
        
        $keys2 = array("username","id","type","type");
        
        
        $comb1 = array(array_combine($keys2, $keys1));
        
        $keys3 = array("value", "value", "value", "value");
        
        $comb2 = array(array_combine($keys3, $values);
        $data = array("id"=> $values["id"], "type" => array("win" => $values["win"], "lost" => $values["lost"]));
        
       	
		
		echo json_encode($data);
        
}
else
{
        echo "failed";
}
?>
