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

// Search database for username
if (isset($_POST['post_user'])) {
    $uid = $_POST['post_user'];
    
    $sql = 'SELECT avatar_path FROM user_info Where id = "' . $uid . '"';
    
    $result = $mysqli->query($sql) or die("Failed to retrieve posts from database.");
    
    $arr = array();
    while ($row = $result->fetch_row()) {
        $arr[] = $row;
    }
    echo json_encode($arr);
    
} 
else {
    echo "fail";
}


?>
