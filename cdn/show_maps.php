<?php
$host= "localhost";  //database host
$username="root";  //database username for log in
$userpass="ecs160web"; //database password for log in
$databasew="web"; //database schema name
$mysqli = new mysqli($host,$username,$userpass,$databasew);

if ($mysqli->connect_errno){
    echo "we have a problem";
}

echo "GOLD";
$sql = "select map_name from map";
$result = mysqli_query($sql);
if (!$result) {
    echo "GOLDEN RETREIVER";
}

while ($row = mysql_fetch_assoc($result)) {
    echo $row['map_name'];
    echo $row['map_path'];
}*/



echo "working??";
?>
