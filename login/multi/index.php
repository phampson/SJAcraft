<?php
header("Content-Type:application/json");

// process client request (via url)
if(!empty($_GET['name'])){
	// 
	$name=$_GET['name'];
	$price=get_price($name);
	if(empty($price))
	{
		deliver_response(200,"book not found",NULL);
		//book not found
	}
	else{
		deliver_response(200,"book found",$price);
	}
}
else 
{
	deliver_response(400,"Invalid Request",NULL);
	//throw invalid request
}
function deliver_response($status, $status_message, $data)
{
	header("HTTP/1.1 $status $status_message");
	$response['status']=$status;
	$response['status_message']=$status_message;
	$response['data']=$data; 
	
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
