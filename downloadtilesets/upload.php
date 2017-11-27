<?php

//db connection
include('/home/ubuntu/ECS160WebServer/start.php');
if ($_SESSION['user_id'] == NULL) {
    echo 'Please <a href="../login/login.html">log in</a> to upload a tileset';
    exit;
}
//uploading file
$target_dir = "tilesets/";

// you will copy file into this directory


$name        = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//fileToUpload is the name from html file, [“name”] is an attribute of $_FILES instance. It also have attribute [“size”] below
$uploadOk      = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
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

// if everything is ok, try to upload file to server
else {
    echo "Your tileset will be properly uploaded once the tileset database is set up.";
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $uploader = $_SESSION['user_id'];
        $sql      = "insert into tilesets (tileset_name, tileset_path, uploader) values('$name','$target_file','$uploader')";
        if ($mysqli->query($sql)) {
            echo "label success";
        } 
        else {
            echo $sql . "label failed ";
        }
        header("location: downloadtilesets.php");
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
