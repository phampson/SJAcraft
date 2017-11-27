<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");

// if post is null or not logged in then don't do anything :) 
if (!isset($_POST) or !isset($_SESSION["user_id"])) {
    header("Location: maprepo.php");
}

print_r($_POST);

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
        $stupidPOSTMapNameConversion = str_replace(".", "_", $map["map_name"]);
        if (isset($_POST[$stupidPOSTMapNameConversion])) {
            
            // 0 is the 'change privacy' box
            if ($_POST[$stupidPOSTMapNameConversion][0] == 'switch') {
                $mysqli->query("UPDATE map SET private=$new WHERE map_name='$mapName' AND uploader=$id");
            } 
            elseif ($_POST[$stupidPOSTMapNameConversion][0] == 'delete') {
                $mapPath   = $map['map_path'];
                $thumbnail = $map['map_thumbnail'];
                exec("rm ../dlc/$mapPath ../dlc/$thumbnail");
                $mysqli->query("DELETE FROM map WHERE map_name='$mapName'");
            } 
            elseif ($_POST[$stupidPOSTMapNameConversion][0] != 'share') {
                echo "<br>GOING TO SHARE<br>";
                $mapName  = $map['map_name'];
                $friendID = $_POST[$stupidPOSTMapNameConversion][0];
                $mysqli->query("INSERT INTO map_settings (map_name, uploader, shared_user) VALUES ('$mapName','$id','$friendID')") or die($myqli->error);
                
            } 
            else {
                // empty else lol.
            }
            
            if (isset($_POST[$stupidPOSTMapNameConversion][1])) {
                if ($_POST[$stupidPOSTMapNameConversion][0] == 'share' and $_POST[$stupidPOSTMapNameConversion][1] != 'unshare') {
                    $mapName  = $map['map_name'];
                    $friendID = $_POST[$stupidPOSTMapNameConversion][1];
                    $mysqli->query("DELETE FROM map_settings WHERE map_name='$mapName' AND uploader=$id AND shared_user=$friendID");
                    ;
                }
            }
            
            if ($_POST[$stupidPOSTMapNameConversion][2] != 'unshare') {
                $mapName  = $map['map_name'];
                $friendID = $_POST[$stupidPOSTMapNameConversion][2];
                $mysqli->query("DELETE FROM map_settings WHERE map_name='$mapName' AND uploader=$id AND shared_user=$friendID");
            }
        }
    }
}


//header("Location: maprepo.php");
?>
