<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_POST)) {
    if (empty($_POST['order'])) {
        $order = "ELO";
    } 
    else {
        $order = $_POST['order'];
    }
    if (!isset($_POST['limit'])) {
        $limit = "10";
    } 
    else {
        $limit = $_POST['limit'];
    }
    $sql = 'SELECT username, win, lost, ELO, id, avatar_path FROM user_info ORDER BY ' . $order . ' DESC LIMIT ' . $limit;
    
    $result = $mysqli->query($sql) or die("project query fail");
    $total = array();
    while ($row = $result->fetch_row()) {
        $arr                = array();
        $arr["name"]        = $row[0];
        $arr["win"]         = $row[1];
        $arr["lost"]        = $row[2];
        $arr["ELO"]         = $row[3];
        $arr["id"]          = $row[4];
        $arr["avatar_path"] = $row[5];
        array_push($total, $arr);
    }
    echo json_encode($total);
} 
else {
    echo "failed";
}
?>

