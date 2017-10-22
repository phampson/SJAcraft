<?php
include("start.php");
header("Content-Type:application/json");
error_reporting(E_ALL); ini_set('display_errors', '1');
// process client request (via url)

if(!empty($_GET['name'])&&empty($_GET['password'])){
	// 
	$name=$_GET['name'];
	$sql = 'SELECT id FROM user_info WHERE username ="'.$name.'" ';
	$result=$mysqli->query($sql) or die("project query fail");
	$temp=($result->fetch_row());
	//print_r($temp);
	if($temp[0]>=1)
	{
		deliver_response(0,200,"User found",$temp[0],"user_id");
	}
	else if(empty($temp))
	{
		deliver_response(1,200,"User not found",NULL,"user_id");
	}
}
else if(!empty($_GET['user_id'])){
	// 
	$id=$_GET['user_id'];
	$sql = 'SELECT username FROM user_info WHERE id ="'.$id.'" ';
	$result=$mysqli->query($sql) or die("project query fail");
	$temp=($result->fetch_row());
	//print_r($temp);
	if(empty($temp))
	{
		deliver_response(1,200,"User not found",NULL,"name");
	}
	else if(!empty($temp))
	{
		deliver_response(0,200,"User found",$temp[0],"name");
	}
}
else if(!empty($_GET['name'])&&!empty($_GET['password'])){
	// 
	$name=$_GET['name'];
	$pass=$_GET['password'];
	$sql = 'SELECT id FROM user_info WHERE username ="'.$name.'" and password= "'.$pass.'" ';
	$result=$mysqli->query($sql) or die("project query fail");
	$temp=($result->fetch_row());
	$sql2 = 'SELECT username FROM user_info WHERE username ="'.$name.'" ';
	$result2=$mysqli->query($sql2) or die("project query fail");
	$temp2=($result2->fetch_row());
	//print_r($temp);
	if(empty($temp2))
	{
		deliver_response(2,200,"User not found",NULL,"user_id");
	}
	else if(!empty($temp2))
	{
		if(empty($temp))
		{
			deliver_response(1,200,"Incorrect Authentication",NULL,"user_id");
		}
		else if(!empty($temp))
		{
			deliver_response(0,200,"Correct Authentication",$temp[0],"user_id");
		}
	}
}
else 
{
	deliver_response(400,"Invalid Request",NULL,"empty");
	//throw invalid request
}
function deliver_response($return_value,$status, $status_message, $data, $var_n)
{
	header("HTTP/1.1 $status $status_message");
	$response['return_value']=$return_value;
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response[$var_n]=$data; 
	
	$json_response=json_encode($response);
	echo $json_response; 

}


function get_price($find)
{
	$book="XU";
	if($find==$book)
	{
		return 333;	
	}
}
?>
