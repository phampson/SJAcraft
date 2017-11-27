<?php
// Helper function
// Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php
// Imports
include('/home/ubuntu/ECS160WebServer/start.php');
// Error Reporting & Variables
$userID     = $_SESSION['user_id'];
$targetDir  = "attachment_files/";
$fileName   = basename($_FILES["fileToUpload"]["name"]);
$fileSize   = $_FILES["fileToUpload"]["size"];
$targetFile = $targetDir . $_FILES["fileToUpload"]["name"];
$uploadedOk = 1;
// Print statements (Delete later)
// Error Checking
// Check file size
if ($fileSize > 1000000) {
    echo "Error";
    $uploadedOk = 0;
}
// Upload file to server
if ($uploadedOk == 1) {
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        
        echo $targetFile;
    } 
    else {
        echo "Error";
    }
}
?>
