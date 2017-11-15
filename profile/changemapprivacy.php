<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");

// if post is null or not logged in then don't do anything :) 
if (!isset($_POST) or !isset($_SESSION["user_id"])) {
    header("Location: maprepo.php");
}

// go through all user's maps, if it exists in POST then change it's privacy.
// is there a better way for this?
$id = $_SESSION["user_id"];
if ($list = $mysqli->query("SELECT * FROM map WHERE uploader=$id")) {

    while ($map = $list->fetch_assoc()) {

        $mapName = $map["map_name"];

        // too late to change the private column from int to bool, which
        // would let me use NOT operator, so this sort of simulates NOT.
        $new = ($map["private"] + 1) % 2;

        // FUN FACT PHP REPLACES ANY "." IN A POST INDEX WITH "_"
        // AND IT ONLY TOOK ME ALL DAY TO FIND OUT
        $stupidPOSTMapNameConversion = str_replace(".","_",$map["map_name"]);
        if (isset($_POST[$stupidPOSTMapNameConversion])) {
            $mysqli->query("UPDATE map SET private=$new WHERE map_name='$mapName' AND uploader=$id");
        }
    }
}


header("Location: maprepo.php");
?>