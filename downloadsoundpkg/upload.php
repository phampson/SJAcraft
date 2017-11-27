<?php
//db connection
include('/home/ubuntu/ECS160WebServer/start.php');
if ($_SESSION['user_id'] == NULL) {
    header("Location: ../login/login.html");
}


//uploading file
$target_dir = "soundpkg/";

// you will copy file into this directory
$name        = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//fileToUpload is the name from html file, [“name”] is an attribute of $_FILES instance. It also have attribute [“size”] below
$uploadOk = 1;

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 10000000) {
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
        //define uploder, and create the insert query
        $uploader = $_SESSION['user_id'];
        $sql      = "insert into soundpkgs (soundpkg_name, soundpkg_path, uploader) values('$name', '$target_file', '$uploader' )";
        
        //try to do the insert 
        if ($mysqli->query($sql) or die($mysqli->error)) {
            echo "label success";
        } 
        else {
            echo $sql . "label failed ";
        }
        
        //on success you will redirect back to soundpkg.php
        //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header("location: downloadsoundpkg.php");
    } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
