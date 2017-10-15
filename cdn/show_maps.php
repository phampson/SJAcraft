<?php
$host= "localhost";  //database host
$username="root";  //database username for log in
$userpass="ecs160web"; //database password for log in
$databasew="web"; //database schema name
$mysqli = new mysqli($host,$username,$userpass,$databasew);

if ($mysqli->connect_errno){
    echo "we have a problem";
}

$query = "select map_name, map_path from map";
if ($result = $mysqli->query($query)) {
    printf("Select returned %d rows.<br>", $result->num_rows);

    $result->close();
}


if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        echo "name: " . $row['map_name'] . " path: " . $row['map_path'] . "<br>";
    }

    $result->close();
}

echo "reached the end";
?>
