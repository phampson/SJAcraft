<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
} else {
    $navpath = "../navbar/navbar.html";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<link rel="stylesheet" href="stylesheet.css">
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
<div class='div1 col-xs-12 col-sm-8 col-xs-offset-0 col-sm-offset-2' id='border-gold'>
<h2>Custom Map Gallery</h2><hr>
<center>
	<form action='dlc.php' method='get' onsubmit='encodeInput(this)'><h2>
		<input style='color:black;' class='btn-sm' type='text' name='searchTerm' placeholder="Search term">
		<input class='btn-simple btn-sm' type='submit' value='Search'>
		<select style='color:black;' class='btn-sm' name='sort'>
			<option disabled selected value>Sort By</option>
			<option value='players'>players</option>
			<option value='uploader'>uploader</option>
			<option value='name'>name</option>
			<option value='date'>date</option>
		</select></h2>		
	</form><hr>
</center>

<script type='text/javascript'>
	function encodeInput(form)
	{
		form.elements['searchTerm'].value = encodeURIComponent(form.elements['searchTerm'].value);
	}
</script>

<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<?php

if (isset($_GET["sort"])) {
    switch ($_GET["sort"]) {
        case "uploader":
            $sortOption = " ORDER BY uploader";
            break;
        case "name":
            $sortOption = " ORDER BY display_name";
            break;
        default:
            $sortOption = "";
    }
} 
else {
    $sortOption = "";
}

if (isset($_GET["searchTerm"]) and $_GET["searchTerm"] != "" and $_GET["searchTerm"] != "SEARCH TERM") {
    $searchTerm = rawurldecode($_GET["searchTerm"]);
    
    
    $query = "SELECT id FROM user_info WHERE username='$searchTerm'";
    if ($result = $mysqli->query($query)) {
        $fetch = $id->fetch_assoc();
        $id    = $fetch["id"];
    }
    $query = "SELECT * FROM packages WHERE (display_name='$searchTerm' OR 
			          uploader='$id')";
} 
else {
    $query = "SELECT * FROM packages";
}
?>
</div>
<?php


		if ($result = $mysqli->query($query)) {
			$count = 0;
		    while ($row = $result->fetch_assoc()) {
			if($count % 4 == 0){
				echo "<div class='row'>";		
			}
			$filepath = $row['filepath'];
			$pname = $row['name'];
			//$map_thumbnail = $row['map_thumbnail'];
			//$numPlayers = $row['num_players'];
			$displayName = $row['name'];
			$uploaderID = $row['uploader'];
			$packageID = $row['id'];
			$userNameQuery = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
			$packagePathQuery = $mysqli->query("select * from packages where id = $packageID");
			$imagePathQuery = $mysqli->query("select * from package_contents where id = $packageID AND type = 0");
		if(!$userNameQuery){	
			throw new Exception("Error in Database query");
		} else {
			$uploaderName = ($userNameQuery->fetch_assoc())['username'];
		}	
		if(!$packagePathQuery){	
			throw new Exception("Error in Database query");
		} else {
			$packagePath = ($packagePathQuery->fetch_assoc())['filepath'];
		}

		if(!$imagePathQuery){	
			throw new Exception("Error in Database query");
		} else {
			$imagePath = ($imagePathQuery->fetch_assoc())['map_thumbnail'];
		}
		echo "
			<div class='col-sm-3 col-xs-12 col-sm-offset-0 col-xs-offset-0'>
             		<div class='div2 thumbnail' style='overflow:auto;'>";
 		if(file_exists($imagePath)){
 			echo "<img src='$imagePath' alt='RATSSSS' style='width:100%'>";
 		} else {
 			echo "<img src='package.png' alt='RATSSSS' style='width:100%'>";
 		}
 
 				echo"	<div class='caption' style='color:white;'>
 						<p>$displayName</p>
 						<p>Uploaded by: <a class='uploaderName' href='../profile/profile.php?id=$uploaderID'>$uploaderName</a></p>
 					</div>
 				<div style='text-align: center'>
 					<button><a href='$packagePath'>download</a></button>
 					<button><a href='displayCMap.php?id=$packageID'>Preview</a></button>				
 				</div>
 				</div>
 			</div>";
        if ($count % 4 == 3) {
            echo "</div>";
        }
        $count = $count + 1;
    }
    
    $result->close();
}
?>
	</div>
	<div class='row'>
	<!--<script type = "text/php" src="show_maps.php"></script>-->
        <div class="col-xs-12 col-sm-12 "><br>
            <!--<div class="thumbnail" onclick="addMap()">-->
                <div class='div2 thumbnail' style='overflow:auto;'>
                <!--<a href="#"> -->
                    
                    <center><div class="caption">
                        <form action="upload.php" method="post" enctype="multipart/form-data"><p>
                            Select package to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload"></p><h2>
                           <input class='btn-simple btn-sm' type="submit" value="Upload Package" name="submit"></h2>
                    </form>
                    </div></center>
                </a>
            </div>
        </div>
	</div>
    </div>
	
</body>
</html>
