<?php
include("start.php");
header("Content-Type:application/json");
error_reporting(E_ALL); ini_set('display_errors', '1');
// process client request (via url)

$valid_username=0;
if(!empty($_GET['name']))
{
	$name=$_GET['name'];
	$sql = 'SELECT * FROM user_info WHERE username ="'.$name.'" ';
	$result=$mysqli->query($sql) or die("project query fail");
	$temp=($result->fetch_row());
	if(!empty($temp))
	{
		$valid_username=1;
	}
}

if(!empty($_GET['name'])&&empty($_GET['password'])&&empty($_GET['info_request'])){
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
else if(!empty($_GET['name'])&&!empty($_GET['info_request']))
{
	$name=$_GET['name'];
	$request=$_GET['info_request'];
	if($request=="ELO")
	{
		$sql = 'SELECT ELO FROM user_info WHERE username ="'.$name.'"';
		$result=$mysqli->query($sql) or die("project query fail");
		$temp=($result->fetch_row());				
		if(empty($temp))
		{
			deliver_response(1,200,"User not found",NULL,"user_ELO");
		}
		else if(!empty($temp))
		{
			deliver_response(0,200,"ELO returned",$temp[0],"user_ELO");
		}		
	}else if($request=="FRIENDS")
	{
		$no_friend=1;
		$res=get_friend($name,$no_friend,$mysqli);
		if($valid_username==0)
		{
			deliver_response(2,200,"User not found",NULL,"friends_list");
		}
		else if($no_friend)
		{
			$res=array();
			deliver_response(0,200,"Friends returned",$res,"friends_list");
		}
		else if(!$no_friend)
		{
			deliver_response(0,200,"Friends returned",$res,"friends_list");
		}		
	}else if($request=="ALL")
	{
		if($valid_username==0)
		{
			header("HTTP/1.1 200 User not found");
			$response['return_value']=1;$response['status']=200;$response['status_message']="User not found";$response['friends_list']=null;$response['user_ELO']=null;$response['user_id']=null;$response['user_name']=null;
			$json_response=json_encode($response, JSON_FORCE_OBJECT);
			echo $json_response; 
		}else 
		{
			$no_friend=1;
			$res=get_friend($name,$no_friend,$mysqli);
			if($no_friend)
			{
				$res=array();
			}
			$sql='select id,username,ELO from user_info WHERE username ="'.$name.'"';
			$result=$mysqli->query($sql) or die("project query fail");
			$temp=($result->fetch_row());
			header("HTTP/1.1 200 User not found");
			$response['return_value']=1;$response['status']=200;$response['status_message']="User not found";$response['friends_list']=$res;$response['user_ELO']=$temp[2];$response['user_id']=$temp[0];$response['user_name']=$temp[1];
			$json_response=json_encode($response, JSON_FORCE_OBJECT);
			echo $json_response; 
		}
	}
}
else if(!empty($_GET['game_id'])&&!empty($_GET['winning_team'])&&!empty($_GET['data'])&&!empty($_GET['end_type'])&&!empty($_GET['game_length']))
{
	$data=$_GET['data'];
		
}
else if(!empty($_GET['game_id'])&&!empty($_GET['team'])&&!empty($_GET['user']))
{
	$id= $_GET['game_id'];
	$team = $_GET['team'];
	$user = $_GET['user'];
	if(count($team)!=count($user))
	{
		echo "user number does not match team number";
	}
	else 
	{
		for($i=0;$i<count($user);$i++)
		{
			$sql = 'SELECT * FROM user_info WHERE id ="'.$user[$i].'" ';
			$result=$mysqli->query($sql) or die("project query fail");
			$temp=($result->fetch_row());	
			if(empty($temp))
			{
				deliver_response2(3,200,"users invalid");
				die;
			} 
		}
		for($i=0;$i<count($team);$i++)
		{
			$sql = 'insert into game_team (game_id,user_id,user_team) value ("'.$id.'","'.$user[$i].'","'.$team[$i].'")';
			$mysqli->query($sql) or die("project query fail");
		}
			deliver_response2(0,200,"Data Received");
	}
}
else 
{
	deliver_response2(400,"Invalid Request",NULL);
	//throw invalid request
}
function deliver_response($return_value,$status, $status_message, $data, $var_n)
{
	header("HTTP/1.1 $status $status_message");
	$response['return_value']=$return_value;
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response[$var_n]=$data; 
	
	$json_response=json_encode($response, JSON_FORCE_OBJECT);
	echo $json_response; 
}

function deliver_response2($return_value,$status, $status_message)
{
	header("HTTP/1.1 $status $status_message");
	$response['return_value']=$return_value;
	$response['status']=$status;
	$response['status_message']=$status_message;
	$json_response=json_encode($response);
	echo $json_response; 
}

function get_friend($name,&$no_friend,$mysqli)
{
	$sql ='select friend_id, username from user_info,(select friend_id from friendlist,(select id from user_info where username = "'.$name.'") as ids where ids.id=friendlist.user_id)as ids2 where ids2.friend_id = id';
	$result=$mysqli->query($sql) or die("project query fail");
	$res=null;
	while($temp=$result->fetch_row())
	{
		$res[$temp[1]]=$temp[0];	
		$no_friend=0;
		//$temp2['friend']
	} 
	//print_r($res);
	return $res;
}
?>
