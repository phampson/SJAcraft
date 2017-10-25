<?php

// Helper function
function phpConsole($data) {
    $output = $data;
    if (is_array($output))
        $output = implode( ',', $output);

    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php



// Imports & Error Reporting
include('../login/start.php');
session_start();

// User logged in
if(isset($_SESSION['user_id'])) {
    
	$sql = 'select * from user_info where username="' . $_SESSION['user_id'] . '"';
    $query = $mysqli->query($sql);

	if($query) {
		$fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$email = $fetch['email'];
		$avatarPath = $fetch['avatar_path'];
		$navpath = "../navbar/navbarlogged.html";
	}
}

// User not logged in
else {    
    
    phpConsole("User not logged in.");
	$username = "username unknown";
	$email = "email unknown";
	$navpath = "../navbar/navbar.html";
}



// Error Reporting & Global variables
error_reporting(E_ALL);
ini_set('display_errors', '1');

$postName = $_POST['postName'];
$message = $_POST['message'];
$category = $_POST['category'];



// Print Statements (Delete later)
echo "Post Name: " . $postName . "<br>";
echo "Message: " . $message . "<br>";
echo "Category: " . $category . "<br>";



// Store in database
$sql = 'INSERT into post (post_user, post_header, post_content, post_date, tag) 
        values("' . $username . '", "' . $postName . '", "' . $message . '", "' . date("Y/m/d") . '", "' . $category . '")';

if ($mysqli->query($sql)) {
    phpConsole("Succesfully updated database.");
}

else {
    phpConsole("Error in updating the database.");
}



/*
$userID = $_SESSION['user_id'];
$targetDir = "avatar_pics/";
$fileName = basename($_FILES["fileToUpload"]["name"]);
$fileSize = $_FILES["fileToUpload"]["size"]; 
$targetFile = $targetDir . $fileName; // CHECK: later change it to $targetFile = $targetDir . $userID . "_" . $fileName;
$uploadedOk = 1;


// Upload file to server
if ($uploadedOk == 1) {

    echo "targetFile: " . $targetFile . "<br>";
 
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {

        $sql = "UPDATE user_info SET avatar_path = '" . $targetFile . "' where username = '" . $userID . "'";
        
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
    //header('Location: ' . '../dlc/dlc.php'); 
}
 */

?>
