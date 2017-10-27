<?php

// Helper function
function phpConsole($data) {
    $output = $data;
    if (is_array($output))
        $output = implode( ',', $output);

    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php



// Imports
session_start();
include('start.php');



// Error Reporting & Variables
error_reporting(E_ALL);
ini_set('display_errors', '1');

$userID = $_SESSION['user_id'];
$targetDir = "avatar_pics/";
$fileName = basename($_FILES["fileToUpload"]["name"]);
$fileSize = $_FILES["fileToUpload"]["size"]; 
$targetFile = $targetDir . $fileName; // CHECK: later change it to $targetFile = $targetDir . $userID . "_" . $fileName;
$uploadedOk = 1;



// Print statements (Delete later)
echo "username: " . $userID . "<br>";
echo "target_file: " . $targetFile . "<br>";
echo "tmp_name: " . $_FILES["fileToUpload"]["tmp_name"] . "<br>";
echo "fileSize: " . $fileSize . "<br>";



// Error Checking

// Check if file exists
if (file_exists($targetFile)) {
    echo "Error: File already exists.";
    $uploadedOk = 0;
}

// Check file size
if ($fileSize > 1000000) {
    echo "Error: File size too large.";
    $uploadedOk = 0;
}



// Upload file to server
if ($uploadedOk == 1) {

    echo "targetFile: " . $targetFile . "<br>";
 
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {

        $sql = "UPDATE user_info SET avatar_path = '" . $targetFile . "' where id = '" . $userID . "'";
        
        if($mysqli->query($sql)) {
            phpConsole("Label success");



	    } else {
		    phpConsole("Label failed");
	    }
        
        echo "The file " . $fileName . " has been uploaded.";
    } else {
        echo "Error: Unable to upload image to server.";
    }

    // Redirect to file
    //header('Location: ' . 'profile.php'); 
}

?>
