<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_GET['badUpload'])) {
   switch ($_GET['badUpload']) {
       case "1":
           echo '
           <script>
               alert("Upload error: Invalid extension.");
           </script>';
           break;
       case "2":
           echo '
           <script>
               alert("Upload error: Filesize too large.");
           </script>';
           break;
       case "3":
           echo '
           <script>
               alert("Upload error: File already exists. Try renaming.");
           </script>';
           break;
       default:
           echo '
           <script>
               alert("Upload error: Something went wrong!");
           </script>';
   }
}

if (isset($_SESSION['user_id'])) {
    $navpath   = "../navbar/navbarlogged.html";
    $repoOwner = $_SESSION['user_id']; 
} else {
    $navpath = "../navbar/navbar.html";
}

if (isset($_GET['id'])) {
    $repoOwner = $_GET['id'];
}

$viewingOwnRepo = $repoOwner == $_SESSION['user_id'];
$repoViewer = $_SESSION['user_id'];

function displayPackages($query, $ownRepo, $private) {
    $mysqli = $GLOBALS["mysqli"];

    if ($result = $mysqli->query($query)) {
	    $count = 0;
        while ($row = $result->fetch_assoc()) {
	        if($count % 4 == 0){
		        echo "<div class='row'>";		
	        }
	        $filepath         = $row['filepath'];
	        $pname            = $row['name'];
	        $displayName      = $row['name'];
	        $uploaderID       = $row['uploader'];
	        $packageID        = $row['id'];
	        $userNameQuery    = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
	        $packagePathQuery = $mysqli->query("select * from packages where id = $packageID");
	        $imagePathQuery   = $mysqli->query("select * from package_contents where id = $packageID AND type = 0");
	        
            if(!$userNameQuery){	
	            throw new Exception("Error in Database query");
            } else {
	            $uploaderName = ($userNameQuery->fetch_assoc())['username'];
            }	
            if(!$packagePathQuery){	
	            throw new Exception("Error in Database query");
            } else {
	            $packagePath = "../downloadCMaps/" . ($packagePathQuery->fetch_assoc())['filepath'];
            }

            if(!$imagePathQuery){	
	            throw new Exception("Error in Database query");
            } else {
	            $imagePath = ($imagePathQuery->fetch_assoc())['map_thumbnail'];
            }
            
            echo "
		            <div class='col-sm-4'>
                			<div class='div2 thumbnail'>";
            if(file_exists("$imagePath")){
	            echo "<img src='../downloadCMaps/$imagePath' alt='RATSSSS' style='width:100%'>";
            } else {
	            echo "<img src='../downloadCMaps/package.png' alt='CATSSSS' style='width:100%'>";
	            

	           //echo "<img src='../downloadCMaps/package.png' alt='CATSSSS' style='width:100%'>";
            }
	        echo"	<div class='caption'>
			        <p>$displayName</p>
			        <p>Uploaded by: <a href='../profile/profile.php?id=$uploaderID'>$uploaderName</a></p>
		        </div>
	        <div style='text-align: center'>
		        <button><a href='$packagePath' download>Download</a></button>
		        <button><a href='../downloadCMaps/displayCMap.php?id=$packageID'>Preview</a></button>";
		    
		    if ($ownRepo == true) {
                echo "<p>Change public/private: </p>";
                echo "<input type='checkbox' name='$packageID" . "[]' value='switch'>";
                echo "<p>Delete map: </p>";
                echo "<input type='checkbox' name='$packageID" . "[]' value='delete'>";
                
                if ($private == true) {
                    echo "<br>Share with a friend only:
				          <select name='$packageID" . "[]' value='share'>
				            <option value='share'></option>";
                    $friends = $mysqli->query("SELECT friend_id FROM friendlist WHERE user_id=" . $_SESSION["user_id"]);
                    while ($friend = $friends->fetch_assoc()) {
                        $friendID       = $friend["friend_id"];
                        $friendQuery    = $mysqli->query("SELECT username FROM user_info WHERE id=$friendID");
                        $friendFetch    = $friendQuery->fetch_assoc();
                        $friendUserName = $friendFetch["username"];
                        echo "<option value='$friendID'>$friendUserName</option>";
                    }
                    echo '</select>';
                    
                    $friendsSharedWith = $mysqli->query("SELECT DISTINCT(shared_user) FROM package_sharing WHERE id=$packageID");
                    echo "<br>Unshare with a friend: <select name='$packageID" . "[]' value='share'><option value='unshare'></option>";
                    while ($friend = $friendsSharedWith->fetch_assoc()) {
                        $friendID = $friend["shared_user"];
                        $friendQuery    = $mysqli->query("SELECT username FROM user_info WHERE id=$friendID");
                        $friendFetch    = $friendQuery->fetch_assoc();
                        $friendUserName = $friendFetch["username"];
                        
                        echo "<option value='$friendID'>$friendUserName</option>";
                    }
                    echo '</select>';
                }
		    }
		    
		    echo"				
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
}

function displayUploadButton()
{
    $mysqli = $GLOBALS["mysqli"];
    
    echo '
		<div class="row">
		    <div class="col-sm-8 col-xs-8 col-sm-offset-2">
				<div class="div2 thumbnail">
					
					<img src="../img/maps/plus.jpg" alt="Map1" style="width:100%">
					<center><div class="caption">
						<form action="uploadpackage.php" method="post" enctype="multipart/form-data"><p>
						    <input type="radio" name="private" value="1">
						    Private <br>
						    <input type="radio" name="private" value="0" checked>
						    Public <br>
						    Select package to upload:
						    <input type="file" name="fileToUpload" id="fileToUpload">
				            Share with a friend only:
				            <select>
				            <option value=""></option>"';
    $friends = $mysqli->query("SELECT friend_id FROM friendlist WHERE user_id=" . $_SESSION["user_id"]);
    while ($friend = $friends->fetch_assoc()) {
        $friendID       = $friend["friend_id"];
        $friendQuery    = $mysqli->query("SELECT username FROM user_info WHERE id=$friendID");
        $friendFetch    = $friendQuery->fetch_assoc();
        $friendUserName = $friendFetch["username"];
        echo "<option value='$friendID'>$friendUserName</option>";
    }
    echo '			    </select> 
		                    <h2><input class="btn-simple btn-sm" type="submit" value="Upload Package" name="submit"></h2>
					  </p>  </form>
					</div></center>
				    </a>
			    </div>
			</div>
		</div>';
}
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

if ($viewingOwnRepo) {
    displayUploadButton();
    
    echo "<form method='post' action='changepackagesettings.php' class='col-xs-12'>";
    
    echo "<div class='row'>";
    echo "<h2>Public Repo</h2><hr>";
    $query = "select * from packages where uploader=$repoOwner and private=0";
    displayPackages($query, true, false);
    echo "</div>";
    
    echo "<div class='row'>";
    echo "<h2>Private Repo</h2><hr>";
    $query = "select * from packages where uploader=$repoOwner and private=1";
    displayPackages($query, true, true);
    echo "</div>";
    
    echo "<h2><input class='btn-simple btn-sm' type='submit' value='Apply Map Changes'></h2>";
    echo "</form>";
    
} else {
    echo "<div class='row'>";
    echo "<h2>Public Repo</h2><hr>";
    $query = "select * from packages where uploader=$repoOwner and private=0";
    displayPackages($query, false, false);
    echo "</div>";



    $magicQuery = "SELECT * FROM packages INNER JOIN package_sharing 
                   ON packages.id=package_sharing.id 
                   WHERE package_sharing.uploader=$repoOwner 
                   AND package_sharing.shared_user=$repoViewer
                   AND packages.private=1";
    if (($mysqli->query($magicQuery))->num_rows) {
        echo "<div class='row'>";
        echo "<h2>Privately Shared Maps</h2><hr>";
        displayPackages($magicQuery, false, false);
        echo "</div>";
    }
}


?>

</div>
</body>
</html>
