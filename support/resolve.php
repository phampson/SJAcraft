<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if (isset($_GET['bugID'])) {
    $sql   = "select * from support where bug_id=" . $_GET['bugID'];
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch      = $query->fetch_assoc();
        $update  = "UPDATE support SET resolved = 'true' where bug_id='".$_GET['bugID']."'";
        if ($mysqli->query($update)) {
        	echo "it worked. ";
    	}
    	else {
    		echo "not yet";
    	}
    }
    // if GET[ID] is set, you're trying to view someone else's profile,
    // so grab their info
    header('Location: ' . '../support/support.php');
}
?>
