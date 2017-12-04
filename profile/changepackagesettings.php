<?php
include_once("/home/ubuntu/ECS160WebServer/start.php");

// if post is null or not logged in then don't do anything :) 
if (!isset($_POST) or !isset($_SESSION["user_id"])) {
    header("Location: packagerepo.php");
}

print_r($_POST);

// go through all user's maps, if it exists in POST then change it's privacy.
// is there a better way for this?
$id = $_SESSION["user_id"];
if ($list = $mysqli->query("SELECT * FROM packages WHERE uploader=$id")) {

    while ($package = $list->fetch_assoc()) {

        $packageID = $package["id"];

        // too late to change the private column from int to bool, which
        // would let me use NOT operator, so this sort of simulates NOT.
        $newPrivacy = ($package["private"] + 1) % 2;

        if (isset($_POST[$packageID])) {

            // 0 is the 'change privacy' box
            if ($_POST[$packageID][0]=='switch') {
                $mysqli->query("UPDATE packages SET private=$newPrivacy WHERE id='$packageID' AND uploader=$id");
            } elseif ($_POST[$packageID][0]=='delete') {
                $packagePath = $package['filepath'];

                exec("rm ../downloadCMaps/$packagePath");
                exec("sudo rm -rf ../downloadCMaps/$packageID");
                $mysqli->query("DELETE FROM packages WHERE id='$packageID'");
                $mysqli->query("DELETE FROM package_contents WHERE id='$packageID'");
                $mysqli->query("DELETE FROM package_sharing WHERE id = '$packageID'");
            } elseif ($_POST[$packageID][0]!='share') {
                echo "<br>GOING TO SHARE<br>";
                $packageName = $package['name'];
                $friendID = $_POST[$packageID][0];
                $mysqli->query("INSERT INTO package_sharing (id, uploader, shared_user) VALUES ('$packageID','$id','$friendID')") or die($myqli->error);
                
            } else {
                // empty else lol.
            }
            
            if (isset($_POST[$packageID][1])) {
                if ($_POST[$packageID][0]=='share' and $_POST[$packageID][1]!='unshare') {
                    $packageName = $package['name'];
                    $friendID = $_POST[$packageID][1];
                    $mysqli->query("DELETE FROM package_sharing WHERE id='$packageID' AND uploader=$id AND shared_user=$friendID");
                }
            }
            
            if ($_POST[$packageID][2]!='unshare') {
                $packageName = $package['name'];
                $friendID = $_POST[$packageID][2];
                $mysqli->query("DELETE FROM package_sharing WHERE id='$packageID' AND uploader=$id AND shared_user=$friendID");
            }
        }
    }
}


header("Location: maprepo.php");
?>
