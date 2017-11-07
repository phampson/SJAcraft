<?php

// Imports & Error Reporting
include('/home/ubuntu/ECS160WebServer/start.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');


// Helper function
function phpConsole($data) {
    $output = $data;
    if (is_array($output))
        $output = implode( ',', $output);

    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php


// User logged in
if(isset($_SESSION['user_id'])) {
    
    $posterID = $_SESSION['user_id'];
	$sql = "SELECT * FROM user_info WHERE id=$posterID";
    $query = $mysqli->query($sql);

	if($query) {
        
        $fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$email = $fetch['email'];
		$avatarPath = $fetch['avatar_path'];
		$navpath = "../navbar/navbarlogged.html";

		phpConsole($_SESSION['user_id']);
		phpConsole($navpath);
		phpConsole($avatarPath);
		phpConsole($email);
		phpConsole($username);
	
        $searchText = $_POST['searchText'];

		// Print Statements (Delete later)
		echo "Text to search: " . $searchText . "<br>";

        $sql = 'SELECT post_header from post WHERE post_header LIKE "%' . $searchText . '%"';
        $result = $mysqli->query($sql) or die("Failed to retrieve posts from database");

        $arr = array();
        while ($row = $result->fetch_row()) {
            $arr[] = $row;
        }

        if ($arr) {
            phpConsole($arr[0]);
        }

        else {
            echo "no posts match your search";
        }
    }
}

// User not logged in
else {    
    
    phpConsole("User not logged in.");
	$username = "username unknown";
	$email = "email unknown";
	$navpath = "../navbar/navbar.html";
}

?>
