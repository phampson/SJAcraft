<?php

// Imports & Error Reporting
include('/home/ubuntu/ECS160WebServer/start.php');

// Helper function
function phpConsole($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    
    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php


if (isset($_SESSION['user_id'])) {
    $posterID = $_SESSION['user_id'];
    $sql      = "SELECT * FROM user_info WHERE id=$posterID";
    $query    = $mysqli->query($sql);
    
    if ($query) {
        $fetch      = $query->fetch_assoc();
        $user_id    = $fetch['id'];
        $email      = $fetch['email'];
        $avatarPath = $fetch['avatar_path'];
        $navpath    = "../navbar/navbarlogged.html";
        $username   = $fetch['username'];
        
        // Error Reporting & Global variables
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        
        $postName = $_POST['postName'];
        $message  = $_POST['message'];
        $category = $_POST['category'];
        
        if (!isset($category)) {
            $category = "general";
        }
        
        // Print Statements (Delete later)
        echo "Post Name: " . $postName . "<br>";
        echo "Message: " . $message . "<br>";
        echo "Category: " . $category . "<br>";
        
        // Store in database
        $sql = "INSERT into post (user_id, post_header, post_content, tag) 
			values('$user_id','$postName','" . $message . "','$category')";
        
        if ($mysqli->query($sql)) {
            phpConsole("Succesfully updated database.");
            $sql   = 'select * from post where user_id="' . $user_id . '" and post_header="' . $postName . '" and post_content="' . $message . '" and tag="' . $category . '"';
            $query = $mysqli->query($sql);
            if ($query) {
                echo "in query check <br>";
                $fetch  = $query->fetch_assoc();
                $postID = $fetch['post_id'];
                echo "ID: " . $postID . "<br>";
                header('refresh:0;url=comments.php?postId=' . $postID . '');
            }
        } 
        else {
            phpConsole("Error in updating the database.");
        }
        
        $sql    = 'SELECT post_id FROM post WHERE user_id="' . $user_id . '" ORDER BY post_date DESC LIMIT 1;';
        $query  = $mysqli->query($sql);
        $fetch  = $query->fetch_assoc();
        $postID = $fetch['post_id'];
        
        $sql = "INSERT into forum_digest (post_id, user_id) values('$postID','$posterID')";
        $mysqli->query($sql);
        
    }
}

// User not logged in
else {
    
    phpConsole("User not logged in.");
    $user_id = "user_id unknown";
    $email   = "email unknown";
    $navpath = "../navbar/navbar.html";
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
