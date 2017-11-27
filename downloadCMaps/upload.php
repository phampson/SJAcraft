<?php
//db connection
include('/home/ubuntu/ECS160WebServer/start.php');

if ($_SESSION['user_id']==NULL) {
	header("Location: ../login/login.html");
}

$target_dir = "cMapPkgs/"; 

$userID = $_SESSION["user_id"];

// you will copy file into this directory
$name = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// check to see if file exists
/*if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    exit;
}*/

// move file from tmp location to its new location
$tempLocation = $_FILES["fileToUpload"]["tmp_name"];
$newLocation = $target_dir . $name;
move_uploaded_file($tempLocation,$newLocation);

// dummy insert to get next ID (folder var, maybe a bad name choice)
$mysqli->query("INSERT INTO packages () VALUES ()");
$folderQuery = "SELECT MAX(id) as 'id' FROM packages";
$folder = (($mysqli->query($folderQuery))->fetch_assoc())['id'];


// insert it into the database
$packageQuery = "UPDATE packages SET
                 uploader = '$userID', 
                 name     = '$name', 
                 filepath = '$newLocation' 
                 WHERE id='$folder'";
$mysqli->query($packageQuery) or die("Error inserting package: " . $mysqli->error);

//unzip the map package!!! 
$zip = new ZipArchive;
$res = $zip->open($newLocation);
if ($res === TRUE) {
  $zip->extractTo($target_dir."/$folder/");

  for ($i=0; $i<$zip->numFiles; $i++) {
    $item = $zip->getNameIndex($i);

    $item = pathinfo($item);
    print_r($item);
    if (isset($item['extension'])) {
      $extension = $item['extension'];
      $name = $item['basename'];
      $path = $item['dirname'];
      echo $extension . "<br>";

      if ($extension == "map") {
        $thumbnail = "cMapPkgs/$folder/" . $item["filename"] . ".png";
        $output    = exec("../dlc/png $thumbnail cMapPkgs/$folder/$name");

        $numPlayers     = substr($output, 0, 1);
        $displayName    = substr($output, 1, strlen($output) - 1);

        $mapUploadQuery = "INSERT INTO package_contents 
                           (id, name, filepath, type, map_thumbnail, num_players, display_name) 
                           VALUES 
                           ('$folder', '$name', 'cMapPkgs/$folder/$name',
                            0, '$thumbnail', '$numPlayers', '$displayName')";

        $mysqli->query($mapUploadQuery) or die ("bad map upload");
        // to-do: create thumbnail, add it to the query ^^
      } elseif ($extension == "png") {
        $tileSetUploadQuery = "INSERT INTO package_contents 
                               (id, name, filepath, type)
                               VALUES
                               ('$folder', '$name', 'cMapPkgs/$folder/$path/$name', 1)";
        $mysqli->query($tileSetUploadQuery) or die ("bad map upload");
      } elseif ($extension == "mid") {
        $soundUploadQuery = "INSERT INTO package_contents
                             (id, name, filepath, type)
                             VALUES
                             ('$folder', '$name', 'cMapPkgs/$folder/$path/$name', 2)";
        $mysqli->query($soundUploadQuery) or die ("bad map upload");
      } else {
        // unwanted file, delete it (this probably doesn't work, fix later)
        // or reject the whole upload? :thinking:
        exec("rm $name");
      }
    } // end if isset(extension)
  } // end for

  $zip->close();
  echo 'YEEAAHHH BOI!';
} else {
  echo 'RATSSSSSS!';
  exit;
}

/*
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
	//Write the variables we put intp the database

	//Map info 
	$thumbnail_path = "cMapPkgs/thumbnails/" . substr($name,0,strlen($name)-4) . ".png";
	$output = exec("./png $thumbnail_path $target_file");
	$numPlayers = substr($output,0,1);
	$displayName = substr($output,1,strlen($output)-1);

	//Image info 
	$image_path = $target_dir . "/images";
	//Sound info
	$sound_path = $target_dir . "/sound";
	//User info
	$uploader = $_SESSION['user_id'];

	$sql = "insert into cMaps (map_name, map_path, map_thumbnail, num_players, display_name, soundpkg_path, image_path, uploader) values('$name','$target_file','$thumbnail_path','$numPlayers','$displayName','$image_path', '$sound_path', '$uploader')";
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
}*/
?>

