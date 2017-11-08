<?php
include("/home/ubuntu/ECS160WebServer/start.php");

/*function displayUserMaps($user,$private) {

    $query = "SELECT * FROM map WHERE uploader=$user AND private=$private";
    $maps = $mysqli->query($query);

    // work on this later
    $i=0;
    for(; $map = $mysqli->fetch_assoc($maps); $i++) {
        if ($i%4 == 0) {
            echo "<div class='row'>;"
        }
        
        $map_path = $row['map_path'];
		$map_name = $row['map_name'];
		$map_thumbnail = $row['map_thumbnail'];
		$numPlayers = $row['num_players'];
		$displayName = $row['display_name'];
		$uploaderID = $row['uploader'];
		
		$userNameQuery = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
		$uploaderName = ($userNameQuery->fetch_assoc())['username'];
		echo "
	<div class='col-sm-3'>
		<div class='thumbnail'>
			
				<img src=$map_thumbnail alt=$map_name style='width:100%'>
				<div class='caption'>
					<p>$displayName</p>
					<p>$numPlayers players</p>
					<p>Uploaded by: $uploaderName</p>
				</div>
			<div style='text-align: center'><button><a href=$map_path download>Download</a></button></div>
		</div>
		
	</div>";
		if($i % 4 == 3){
			echo "</div>";		
		}
    }
    if($i%4 != 3) {
        echo "</div>";
    }
}

function displayAllUserMaps($id) {
    echo "These are your public maps:<br>";
    displayUserMaps($id,0);

    echo "These are your private maps:<br>";
    displayUserMaps($id,1);
}*/

function phpConsole($data) {
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



if(isset($_GET["id"])) {
    $user_id = $_GET["id"];
    $viewingOwnRepo = false;
} else if (isset($_SESSION["user_id"])) {
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
function showMaps($query){
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
			
			$userNameQuery = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
			$uploaderName = ($userNameQuery->fetch_assoc())['username'];

			echo "
		<div class='col-sm-3'>
			<div class='thumbnail'>
				
					<img src=$map_thumbnail alt=$map_name style='width:100%'>
					<div class='caption'>
						<p>$displayName</p>
						<p>$numPlayers players</p>
						<p>Uploaded by: $uploaderName</p>
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

function displayUploadButton() {
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
						    <input type="submit" value="Upload Image" name="submit">
					</form>
					</div>
				</a>
			</div>
			</div>
		</div>';
		
}




if ($viewingOwnRepo) {
    displayUploadButton();
    echo"<div class='row'>";
    $query = "select * from map where uploader = $user_id and private=0";
    echo "<h2 style='color: white; text-align: center;'>Public Repo</h2>";
    showMaps($query);
    echo "</div>";
    echo"<div class='row'>";
    echo "<h2 style='color: white; text-align: center;'>Private Repo</h2>";
    $query = "select * from map where uploader = $user_id and private=1";
    showMaps($query);
    echo "</div>";
} else {
    echo"<div class='row'>";
    $query = "select * from map where uploader=$user_id and private=0";
    echo "<h2 style='color: white; text-align: center;'>Public Repo</h2>";
    showMaps($query);
}
		

		?>

?>

</div>
</body>
</html>
