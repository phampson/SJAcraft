<?php 
include "start.php";
error_reporting(E_ALL); ini_set('display_errors', '1');

if(isset($_POST['user_type']))
{
	$type=$_POST['user_type'];
	if($type==1)
	{
		$sql = 'SELECT username FROM user_info WHERE game_logged = "true"';
	}
	else if($type==2)
	{
		$sql = 'SELECT username FROM user_info WHERE web_logged = "true"';
	}
	$result=$mysqli->query($sql) or die("project query fail");
	$arr = array();
	while ($row = $result->fetch_row()) {
	    $arr[] = $row;
	}
	echo json_encode($arr);
}
else 
{
	echo "failed";
}
?>
