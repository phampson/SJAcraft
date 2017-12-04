<?php
//db connection
include('/home/ubuntu/ECS160WebServer/start.php');

if ($_SESSION['user_id'] == NULL) {
    echo 'Please <a href="../login/login.html">log in</a> to upload a map!';
    exit;
}

//uploading file
$target_dir    = "../dlc/maps/";

// you will copy file into this directory
$name          = basename($_FILES["fileToUpload"]["name"]);

$target_file   = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//fileToUpload is the name from html file, [“name”] is an attribute of $_FILES instance. It also have attribute [“size”] below
$uploadOk      = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
if ($imageFileType != ".png" || $imageFileType != ".jpg" || $imageFileType != ".gif" ) {
    echo "Sorry, that file type is not allowed.<br>";
    echo "Allowable file types: .png, .jpg, .gif";
    $uploadOk = 0;
}

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
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploader       = $_SESSION['user_id'];
        $thumbnail_path = "../dlc/maps/thumbnails/" . substr($name, 0, strlen($name) - 4) . ".png";
        
        $output      = exec("../dlc/png $thumbnail_path $target_file");
        $numPlayers  = substr($output, 0, 1);
        $displayName = substr($output, 1, strlen($output) - 1);
        $private     = $_POST['private'];
        $sql         = "insert into map (map_name, map_path, map_thumbnail, num_players, display_name, uploader, private) values('$name','$target_file','$thumbnail_path','$numPlayers','$displayName','$uploader','$private')";
        if ($mysqli->query($sql)) {
            echo "label success";
        } 
        else {
            echo $sql . "label failed ";
        }
        echo $thumbnail_path;
        echo $target_file;
        echo $numPlayers;
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        //header("location: maprepo.php");
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

