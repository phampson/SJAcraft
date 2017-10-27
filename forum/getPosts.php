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
error_reporting(E_ALL);
ini_set('display_errors', '1');

$sql = 'SELECT * from post';
$result = $mysqli->query($sql) or die("Failed to retrieve posts from database.");

$arr = array();
while ($row = $result->fetch_row()) {
    $arr[] = $row;
}
echo json_encode($arr);

?>
