<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (!empty($_POST['uploader'])) {
    $name = $_POST['uploader'];
    $sql  = 'SELECT * FROM user_info WHERE id ="' . $name . '" ';
    $result = $mysqli->query($sql) or die("project query fail");
    $temp = ($result->fetch_row());
    if (empty($temp)) {
        deliver_response(1, 200, "invalid id", $_POST['uploader'], "uploader");
        die;
    }
} 
else {
    deliver_response(2, 200, "no uploader", NULL, "uploader");
    die;
}

$private = -1;
if (!empty($_POST['private'])) {
    $tem = $_POST['private'];
    if ($tem == 'true') {
        $private = 1;
    } else if ($tem == 'false') {
        $private = 0;
    } else {
        deliver_response(8, 200, "incorrect private or public", $_POST['uploader'], "uploader");
        die;
    }
} 
else {
    deliver_response(9, 200, "empty private or public", $_POST['uploader'], "uploader");
    die;
}


//uploading file
$target_dir = "maps/";
$uploader   = $_POST['uploader'];
// you will copy file into this directory


$name        = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//fileToUpload is the name from html file, [“name”] is an attribute of $_FILES instance. It also have attribute [“size”] below

$uploadOk      = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);


// check the extension
$file_parts = pathinfo($target_file);

if ($file_parts['extension'] != 'map') {
    deliver_response(10, 200, "not map file", $uploader , "uploader");
    die;
}

// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
    deliver_response(3, 200, "file already exists", $uploader, "uploader");
    die;
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 1000000) {
    deliver_response(4, 200, "file is too large", $uploader, "uploader");
    die;
    //echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
    deliver_response(5, 200, "file was not uploaded", $uploader, "uploader");
    die;
    // if everything is ok, try to upload file to server
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $thumbnail_path = "maps/thumbnails/" . substr($name, 0, strlen($name) - 4) . ".png";
        $output         = exec("./png $thumbnail_path $target_file");
        $numPlayers     = substr($output, 0, 1);
        $displayName    = substr($output, 1, strlen($output) - 1);
        $sql            = "insert into map (map_name, map_path, map_thumbnail, num_players, display_name, uploader, private) values('$name','$target_file','$thumbnail_path','$numPlayers','$displayName','$uploader','$private')";
        if ($mysqli->query($sql)) {
            //echo "label success";
        } 
        else {
            deliver_response(6, 200, "query falied", $uploader, "uploader");
            die;
        }
        deliver_response(0, 200, $_FILES["fileToUpload"]["name"] + " has been uploaded", $uploader, "uploader");
        die;
    } 
    else {
        deliver_response(7, 200, "unknown error", $uploader, "uploader");
        die;
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
