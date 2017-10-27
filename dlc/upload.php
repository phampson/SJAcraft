<?php
//db connection
session_start();

if ($_SESSION['user_id']==NULL) {
	echo 'Please <a href="../login/login.html">log in</a> to upload a map!';
	exit;
}

$host= "localhost";  //database host
$username="root";  //database username for log in
$userpass="ecs160web"; //database password for log in
$databasew="web"; //database schema name
$mysqli = new mysqli($host,$username,$userpass,$databasew);
if ($mysqli->connect_errno){
echo "we have a problem";
}

//uploading file
error_reporting(E_ALL); ini_set('display_errors', '1');
$target_dir = "maps/"; 
// you will copy file into this directory
$name = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//fileToUpload is the name from html file, [“name”] is an attribute of $_FILES instance. It also have attribute [“size”] below
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file to server
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	$uploader = $_SESSION['user_id'];
	$thumbnail_path = "maps/thumbnails/" . substr($name,0,strlen($name)-4) . ".png";
	$output = exec("./png $thumbnail_path $target_file");
	$numPlayers = substr($output,0,1);
	$displayName = substr($output,1,strlen($output)-1);
	$sql = 'insert into map (map_name, map_path, map_thumbnail, num_players, display_name, uploader) values(" '.$name.' "," '.$target_file.' "," '.$thumbnail_path.'"," '.$numPlayers.'"," '.$displayName.'","'.$uploader.'")';
	if($mysqli->query($sql)) {
		echo "label success";
	} else {
		echo $sql."label failed ";
	}
	echo $thumbnail_path;
	echo $target_file;
	echo $numPlayers;
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    	header("location: dlc.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

