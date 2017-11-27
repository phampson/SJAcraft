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


if (isset($_POST['id'])) {
    //phpConsole("user_id is set");
    $userID = $_POST['id'];
    
    $sql = 'SELECT username from user_info WHERE id ="' . $userID . '"';
    $result = $mysqli->query($sql) or die("Failed to retrieve posts from database.");
    
    $arr = array();
    while ($row = $result->fetch_row()) {
        $arr[] = $row;
    }
    echo json_encode($arr);
}

else {
    //phpConsole("user_id is not set");
    echo "Error :(";
}

?>
