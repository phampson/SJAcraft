<?php
//db connection
include('/home/ubuntu/ECS160WebServer/start.php');

if ($_SESSION['user_id'] == NULL) {
    header("Location: ../login/login.html");
    exit;
}

$target_dir = "cMapPkgs/";

$userID = $_SESSION["user_id"];

// you will copy file into this directory
$name        = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// check to see if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    exit;
}

// move file from tmp location to its new location
$tempLocation = $_FILES["fileToUpload"]["tmp_name"];
$newLocation  = $target_dir . $name;
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
$mysqli->query($packageQuery) or die("Error inserting package: " . $mysqli->error);

//unzip the map package!!! 
$zip = new ZipArchive;
$res = $zip->open($newLocation);
if ($res === TRUE) {
    $zip->extractTo($target_dir . "/$folder/");
    
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $item = $zip->getNameIndex($i);
        
        $item = pathinfo($item);
        print_r($item);
        if (isset($item['extension'])) {
            $extension = $item['extension'];
            $name      = $item['basename'];
            $basename  = $item['filename'];
            $path      = $item['dirname'];
            echo $extension . "<br>";

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
                
                $mysqli->query($mapUploadQuery) or die("bad map upload");
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
                    $mysqli->query($animationInsertQuery) or die("lol the gifmaker thing messed up." . $mysqli->error());
		        } else {
		        // else it's a tileset
		            $tileSetUploadQuery = "INSERT INTO package_contents 
                               (id, name, filepath, type)
                               VALUES
                               ('$folder', '$name', 'cMapPkgs/$folder/$path/$name', 1)";
                    $mysqli->query($tileSetUploadQuery) or die("bad map upload");
                }
            } elseif ($extension == "mp3" || $extension == "wav") {
                $soundUploadQuery = "INSERT INTO package_contents
                             (id, name, filepath, type)
                             VALUES
                             ('$folder', '$name', 'cMapPkgs/$folder/$path/$name', 2)";
                $mysqli->query($soundUploadQuery) or die("bad map upload");
            } elseif ($extension == "mid" || $extension == "midi") {
	 	//We will convert the midi to a wav so we can actually play it
		exec("timidity cMapPkgs/$folder/$path/$name -Ow -o cMapPkgs/$folder/$path/$basename.mp3");	
	        $soundUploadQuery = "INSERT INTO package_contents
                             (id, name, filepath, type)
                             VALUES
                             ('$folder', '$name', 'cMapPkgs/$folder/$path/$basename.mp3', 2)";
                $mysqli->query($soundUploadQuery) or die("bad map upload");
		echo "sudo timidity cMapPkgs/$folder/$path/$name -Ow -o cMapPkgs/$folder/$path/$basename.mp3";
	    } else {
                // unwanted file, delete it (this probably doesn't work, fix later)
                // or reject the whole upload? :thinking:
                //exec("rm $name");
            }
        } // end if isset(extension)
    } // end for
    
    $zip->close();
    echo 'YEEAAHHH BOI!';
    header("Location: downloadCMaps.php");
} 
else {
    echo 'RATSSSSSS!';
    exit;
}

?>


