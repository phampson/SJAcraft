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
//echo"s";


$target_dir = "cMapPkgs/";

$userID = $_POST['uploader'];

// you will copy file into this directory
$name        = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// check to see if file already exists
if (file_exists($target_file)) {
    deliver_response(3, 200, "file already exists", $userID , "uploader");
    die;
}

// check the extension
$file_parts = pathinfo($target_file);

if ($file_parts['extension'] != 'zip') {
    deliver_response(0, 200, "not zip file", $userID , "uploader");
    die;
}

// move file from tmp location to its new location
$tempLocation = $_FILES["fileToUpload"]["tmp_name"];
$newLocation  = $target_dir . $name;
//echo $tempLocation.'----'.$newLocation
move_uploaded_file($tempLocation, $newLocation);

// dummy insert to get next ID (folder var, maybe a bad name choice)
$mysqli->query("INSERT INTO packages () VALUES ()");
$folderQuery = "SELECT MAX(id) as 'id' FROM packages";
$fq          = $mysqli->query($folderQuery);
$folder      = "";
if ($fq) {
    $fetchFolder = $fq->fetch_assoc();
    $folder      = $fetchFolder['id'];
}

// insert it into the database
$packageQuery = "UPDATE packages SET
                 uploader = '$userID', 
                 name     = '$name', 
                 filepath = '$newLocation' 
                 WHERE id = '$folder'";
if($mysqli->query($packageQuery)){}else{ deliver_response(6, 200, "query falied", $userID , "uploader");  die;} 
//unzip the map package!!! 
$zip = new ZipArchive;
$res = $zip->open($newLocation);
if ($res === TRUE) {
    $zip->extractTo($target_dir . "/$folder/");
    
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $item = $zip->getNameIndex($i);
        
        $item = pathinfo($item);
        //print_r($item);
        if (isset($item['extension'])) {
            $extension = $item['extension'];
            $name      = $item['basename'];
            $basename  = $item['filename'];
            $path      = $item['dirname'];
            //echo $extension . "<br>";

            if ($extension == "map") {
                $thumbnail = "cMapPkgs/$folder/" . $item["filename"] . ".png";
                $output    = exec("../dlc/png $thumbnail cMapPkgs/$folder/$path/$name");
                
                $numPlayers  = substr($output, 0, 1);
                $displayName = substr($output, 1, strlen($output) - 1);
                
                $mapUploadQuery = "INSERT INTO package_contents 
                           (id, name, filepath, type, map_thumbnail, num_players, display_name) 
                           VALUES 
                           ('$folder', '$name', 'cMapPkgs/$folder/$path/$name',
                            0, '$thumbnail', '$numPlayers', '$displayName')";
                
                //$mysqli->query($mapUploadQuery) or die("bad map upload");
                if($mysqli->query($mapUploadQuery)){}else{ deliver_response(7, 200, "map query falied", $userID , "uploader");  die;} 
            } elseif ($extension == "png") {
		        // check for .dat, if it's there then it's an animation
		        if (file_exists("cMapPkgs/$folder/$path/$basename.dat")) {
                    list($width,$height,$type,$attr) = getimagesize("cMapPkgs/$folder/$path/$name");
                    $size = $width . "x" . $width;

                    //split into individual frames
                    exec("convert -crop $size cMapPkgs/$folder/$path/$name cMapPkgs/$folder/c_%d.png");
                    
                    // repage so it's not a super tall gif
                    for ($j=0; file_exists("cMapPkgs/$folder/c_$j.png"); $j++) {
                        exec("convert -page $size+0+0 cMapPkgs/$folder/c_$j.png cMapPkgs/$folder/c_$j.png");
                    }

                    exec("convert -dispose Background -delay 20 -loop 0 cMapPkgs/$folder/c_*.png cMapPkgs/$folder/$basename.gif");
                    exec("rm cMapPkgs/$folder/c_*.png");
                    
                    $animationInsertQuery = "INSERT INTO package_contents
                                             (id, name, filepath, type)
                                             VALUES
                                             ('$folder', '$name', 'cMapPkgs/$folder/$basename.gif', 3)";
                    //$mysqli->query($animationInsertQuery) or die("lol the gifmaker thing messed up." . $mysqli->error());
                    if($mysqli->query($animationInsertQuery)){}else{ deliver_response(9, 200, "gif falied", $userID , "uploader");  die;} 
		        } else {
		        // else it's a tileset
		            $tileSetUploadQuery = "INSERT INTO package_contents 
                               (id, name, filepath, type)
                               VALUES
                               ('$folder', '$name', 'cMapPkgs/$folder/$path/$name', 1)";
                  	if($mysqli->query($tileSetUploadQuery)){}else{ deliver_response(7, 200, "map query falied", $userID , "uploader");  die;} 
                    //$mysqli->query($tileSetUploadQuery) or die("bad map upload");
                }
            } elseif ($extension == "mid" || $extension == "mp3" || $extension == "wav") {
                $soundUploadQuery = "INSERT INTO package_contents
                             (id, name, filepath, type)
                             VALUES
                             ('$folder', '$name', 'cMapPkgs/$folder/$path/$name', 2)";
                 if($mysqli->query($soundUploadQuery)){}else{ deliver_response(7, 200, "map query falied", $userID , "uploader");  die;} 
                //$mysqli->query($soundUploadQuery) or die("bad map upload");
            } else {
                // unwanted file, delete it (this probably doesn't work, fix later)
                // or reject the whole upload? :thinking:
                //exec("rm $name");
            }
        } // end if isset(extension)
    } // end for
    
    $zip->close();
    deliver_response(5, 200, "upload successfully", $userID , "uploader");  die;
    //header("Location: downloadCMaps.php");
} 
else {
    deliver_response(8, 200, "can not create zip file", $userID , "uploader");  die;
    exit;
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
