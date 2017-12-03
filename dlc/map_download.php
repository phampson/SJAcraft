<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if (empty($_GET['map'])) 
{
	deliver_response(0, 200, "empty name", NULL, "map");die;
}
if (!empty($_GET['map'])) {
    $map = $_GET['map'];
    $sql  = 'SELECT map_path FROM map WHERE map_name ="' . $map . '" ';
    $result = $mysqli->query($sql) or die("project query fail");
    $temp = ($result->fetch_row());
    if (empty($temp)) {
        deliver_response(1, 200, "map not found", $map, "map");
        die;
    }
    else{
    	$file = $temp[0];//echo $file;
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			//deliver_response(2, 200, "download successfully", $map, "map");
   		    die;
		}
    }
} 
function deliver_response($return_value, $status, $status_message, $data, $var_n)
{
    header("HTTP/1.1 $status $status_message");
    $response['return_value']   = $return_value;
    $response['status']         = $status;
    $response['status_message'] = $status_message;
    $response[$var_n]           = $data;
    
    $json_response = json_encode($response, JSON_FORCE_OBJECT);
    echo $json_response;
}
?>
