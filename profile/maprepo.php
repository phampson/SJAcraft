<?php
include("/home/ubuntu/ECS160WebServer/start.php");

function phpConsole($data) 
{
    $output = $data;
    if (is_array($output))
        $output = implode( ',', $output);
    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php


if(isset($_SESSION["user_id"])) {
    $navpath = "../navbar/navbarlogged.html";
} else {
    $navpath = "../navbar/navbar.html";
}



if (isset($_GET["id"])) {
    $user_id = $_GET["id"];
    $viewingOwnRepo = false;
} elseif (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $viewingOwnRepo = true;
} else {
    header("Location: ../login/login.html");
}
$query = $mysqli->query("select * from user_info where id=$user_id");
$mapRepoOwner = $query->fetch_assoc()["username"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Nav Bar -->
<div id="navbar"></div>
<?php
echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<!-- CDN gallery -->
<h2 style="color: white; text-align: center;"><?php echo $mapRepoOwner."'s" ?> Map Repo</h2>

<div class="col-sm-8 col-sm-offset-2">

<?php
function showMaps($query, $ownRepo, $private){
    $mysqli = $GLOBALS['mysqli'];
		if ($result = $mysqli->query($query)) {
		    $count = 0;
		    while ($row = $result->fetch_assoc()) {
		        if($count % 4 == 0){
				    echo "<div class='row'>";		
		        }
			$map_path = "../dlc/".$row['map_path'];
			$map_name = $row['map_name'];
			$map_thumbnail = "../dlc/".$row['map_thumbnail'];
			$numPlayers = $row['num_players'];
			$displayName = $row['display_name'];
			$uploaderID = $row['uploader'];
			
			echo "
		<div class='col-sm-3'>
			<div class='thumbnail'>
				
					<img src=$map_thumbnail alt=$map_name style='width:100%'>
					<div class='caption'>
						<p>$displayName</p>
						<p>$numPlayers players</p>";
            if ($ownRepo==1) {
                echo "Change public/private: ";
                echo "<input type='checkbox' name='$map_name"."[]' value='switch'>";
                echo "Delete map: ";
                echo "<input type='checkbox' name='$map_name"."[]' value='delete'>";
                
                if ($private == true) {
                    echo "<br>Share with a friend only:
				          <select name='$map_name"."[]' value='share'>
				            <option value='share'></option>";
	                $friends = $mysqli->query("SELECT friend_id FROM friendlist WHERE user_id=" . $_SESSION["user_id"]);
	                while ($friend = $friends->fetch_assoc()) {
	                    $friendID = $friend["friend_id"];
	                    $friendUserName = (($mysqli->query("SELECT username FROM user_info WHERE id=$friendID"))->fetch_assoc())["username"];
	                    echo "<option value='$friendID'>$friendUserName</option>";
	                }
		            echo '</select>';
		            
		            phpConsole($map_name);
		            $friendsSharedWith = $mysqli->query("SELECT shared_user FROM map_settings WHERE map_name='$map_name'");
		      
		            echo "<br>Unshare with a friend: <br> <select name='$map_name"."[]' value='share'><option value='unshare'></option>";
		            while ($friend = $friendsSharedWith->fetch_assoc()) {
		                $friendID = $friend["shared_user"];
		                phpConsole($friendID);
		                $friendUserName = (($mysqli->query("SELECT username FROM user_info WHERE id=$friendID"))->fetch_assoc())["username"];
		                
		                echo "<option value='$friendID'>$friendUserName</option>";
		            }
		            echo '</select>';
		        }
            }
            echo "
					</div>
				<div style='text-align: center'><button><a href=$map_path download>Download</a></button></div>
			</div>
			
		</div>";
			if($count % 4 == 3){
				echo "</div>";		
			}
			$count = $count + 1;
		}
		$result->close();
	}
}

function displayUploadButton() 
{
    $mysqli = $GLOBALS["mysqli"];
    
		echo'
		<div class="row">
		    <div class="col-sm-3">
				<div class="thumbnail">
					
					<img src="../img/maps/plus.jpg" alt="Map1" style="width:100%">
					<div class="caption">
						<form action="upload.php" method="post" enctype="multipart/form-data">
						    <input type="radio" name="private" value="1">
						    Private <br>
						    <input type="radio" name="private" value="0" checked>
						    Public <br>
						    Select map to upload:
						    <input type="file" name="fileToUpload" id="fileToUpload">
				            Share with a friend only:
				            <select>
				            <option value=""></option>"';
	    $friends = $mysqli->query("SELECT friend_id FROM friendlist WHERE user_id=" . $_SESSION["user_id"]);
	    while ($friend = $friends->fetch_assoc()) {
	        $friendID = $friend["friend_id"];
	        $friendUserName = (($mysqli->query("SELECT username FROM user_info WHERE id=$friendID"))->fetch_assoc())["username"];
	        echo "<option value='$friendID'>$friendUserName</option>";
	    }
		echo '			    </select> 
		                    <input type="submit" value="Upload Map" name="submit">
					    </form>
					</div>
				    </a>
			    </div>
			</div>
		</div>';
}




if ($viewingOwnRepo) {
    displayUploadButton();

    echo "<form method='post' action='changemapsettings.php'>";

    echo"<div class='row'>";
    echo "<h2 style='color: white; text-align: center;'>Public Repo</h2>";
    $query = "select * from map where uploader = $user_id and private=0";
    showMaps($query,1,false);
    echo "</div>";

    echo"<div class='row'>";
    echo "<h2 style='color: white; text-align: center;'>Private Repo</h2>";
    $query = "select * from map where uploader = $user_id and private=1";
    showMaps($query,1,true);
    echo "</div>,";

    echo "<input type='submit' value='Apply Map Changes'>";
    echo "</form>";

} else {
    echo"<div class='row'>";
    echo "<h2 style='color: white; text-align: center;'>Public Repo</h2>";

    $query = "select * from map where uploader=$user_id and private=0";
    showMaps($query);
}
		

?>

</div>
</body>
</html>
