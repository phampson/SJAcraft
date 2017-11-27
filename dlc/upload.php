<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if ($_SESSION['user_id'] == NULL) {
    header("Location: ../login/login.html");
}
function error_re($text)
{
    echo '<script type="text/javascript">
		window.location.href = "./dlc.php?error=' . $text . '";
	 	</script>';
    exit(0);
}

//uploading file


// you will copy file into this directory
$target_dir = "maps/";

$name        = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//fileToUpload is the name from html file, [“name”] is an attribute of $_FILES instance. It also have attribute [“size”] below

$uploadOk      = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check file extension
$file_parts = pathinfo($target_file);

if ($file_parts['extension'] != 'map') {
    error_re("0");
}


// Check if file already exists
if (file_exists($target_file)) {
    //$Warning = "1";
    $uploadOk = 0;
    error_re("1");
}



// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    error_re("2");
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    error_re("3");
    // if everything is ok, try to upload file to server
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploader       = $_SESSION['user_id'];
        $thumbnail_path = "maps/thumbnails/" . substr($name, 0, strlen($name) - 4) . ".png";
        $output         = exec("./png $thumbnail_path $target_file");
        $numPlayers     = substr($output, 0, 1);
        $displayName    = substr($output, 1, strlen($output) - 1);
        $sql            = "insert into map (map_name, map_path, map_thumbnail, num_players, display_name, uploader,private) values('$name','$target_file','$thumbnail_path','$numPlayers','$displayName','$uploader',0)";
        if ($mysqli->query($sql)) {
            error_re("4");
        } 
        else {
            error_re("5");
        }
        header("location: dlc.php");
    } 
    else {
        error_re("6");
    }
}
?>
