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

if (isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];
    
    $sql = 'SELECT * from post WHERE post_header LIKE "%' . $searchText . '%"';
    $result = $mysqli->query($sql) or die("Failed to retrieve posts from database");
    
    $arr = array();
    while ($row = $result->fetch_row()) {
        $arr[] = $row;
    }
    
    // searchText matches posts in database
    if ($arr) {
        echo json_encode($arr);
    }
    
    // searchText does not match any post in database
    else {
        echo "0";
    }
}

else {
    echo "Error: Did not receive search text";
}

?>
