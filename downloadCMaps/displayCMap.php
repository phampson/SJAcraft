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

<h2 style="color: white; text-align: center;">Contents</h2>
<div class='col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2'>

<?php
$id =  $_GET['id'];

//gets the correct package based on the id passed to this page
$query = "select * from packages where id = " . $id;
$result = $mysqli->query($query); 
if ($result !== NULL && $result->num_rows !== 0) {
    //collect data about this id in the packages database
    $row = $result->fetch_assoc();
    $uploader = $row['uploader'];
    $name = $row['name'];
    $packageFilePath = $row['filepath'];

    //First displays the maps
    $query = "select * from package_contents where id = " . $id . " AND type = 0";
    $result = $mysqli->query($query);
    if($result !== NULL && $result->num_rows !== 0){
      echo "<h2 style='color: white; text-align: center;'>Maps</h2>";
      $count = 0;
      while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $displayname = $row['display_name'];
        $image = $row['map_thumbnail'];
        if ($count % 4 == 0) {
          echo "<div class='row'>";
        }
	
		

        echo "
                <div class='col-sm-3'>
                    <div class='div1 thumbnail'>
                        <img src='$image' alt='$image' style='width:100%'>
                        <div class='caption'>
                            <p>$name</p>
                            <p>Uploaded by: <a href='../profile/profile.php?id=$uploader'>$uploader</a></p>
                        </div>
                    <div style='text-align: center'>
                    </div>
                </div>
        
                </div>";
        if ($count % 4 == 3) {
            echo "</div>";
        }
        $count = $count + 1;
	}

        echo "</div>";
    }

    //Now display all images
    $query = "select * from package_contents where id = " . $id . " AND type = 1";
    $result = $mysqli->query($query);
    if($result !== NULL && $result->num_rows !== 0){
      echo "<h2 style='color: white; text-align: center;'>Images</h2>";
      $count = 0;
      while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $filepath = $row['filepath'];
        if ($count % 4 == 0) {
          echo "<div class='row'>";
        }

        echo "
                <div class='col-sm-3'>
                    <div class='div1 thumbnail'>
                        <img src='$filepath' alt='$filepath' style='width:100%'>
                        <div class='caption'>
                            <p>$name</p>
                            <p>Uploaded by: <a href='../profile/profile.php?id=$uploader'>$uploader</a></p>
                        </div>
                    <div style='text-align: center'>
                    </div>
                </div>
        
                </div>";
        if ($count % 4 == 3) {
            echo "</div>";
        }
        $count = $count + 1;
        }
        echo "</div>";
    }


    //Now display all animations
    $query = "select * from package_contents where id = " . $id . " AND type = 3";
    $result = $mysqli->query($query);
    if($result !== NULL && $result->num_rows !== 0){
      echo "<h2 style='color: white; text-align: center;'>Animations</h2>";
      $count = 0;
      while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $filepath = $row['filepath'];
        if ($count % 4 == 0) {
          echo "<div class='row'>";
        }

        echo "
                <div class='col-sm-3'>
                    <div class='div1 thumbnail'>
                        <img src='$filepath' alt='$filepath' style='width:100%'>
                        <div class='caption'>
                            <p>$name</p>
                            <p>Uploaded by: <a href='../profile/profile.php?id=$uploader'>$uploader</a></p>
                        </div>
                    <div style='text-align: center'>
                    </div>
                </div>
        
                </div>";
        if ($count % 4 == 3) {
            echo "</div>";
        }
        $count = $count + 1;
        }
        echo "</div>";
    }

    //Now display all sounds     
    $query = "select * from package_contents where id = " . $id . " AND type = 2";
    $result = $mysqli->query($query);
    if($result !== NULL && $result->num_rows !== 0){
      echo "<h2 style='color: white; text-align: center;'>Sound</h2>";
      $count = 0;
      while ($row = $result->fetch_assoc()) {
        
      $name = $row['name'];
      $filepath = $row['filepath'];
	if ($count % 4 == 0) {
          echo "<div class='row'>";
        }

        echo "
                <div class='col-sm-3'>
                    <div class='div1 thumbnail'>
                        <img src='soundPic.png' alt='Whyyyyy cruel worlllld' style='width:100%'>
                        <div class='caption'>
		 	  <audio id='$count'>
			    <source src='$filepath'>
			  </audio>

                            <p>$name</p>
                            <p>Uploaded by: <a href='../profile/profile.php?id=$uploader'>$uploader</a></p>
                        </div>
                    <div style='text-align: center'>
                       <button onclick='document.getElementById($count).play()'>Play</button> 
                       <button onclick='document.getElementById($count).pause()'>Pause</button>
                       <button onclick='document.getElementById($count).pause(); document.getElementById($count).currentTime = 0;'>Stop</button>
                    </div>
                </div>
        
                </div>";
        if ($count % 4 == 3) {
            echo "</div>";
        }
        $count = $count + 1;
        }
    }
} else {
  echo "
    <h2 style='color: white; text-align: center;'>No Package Found :(</h2>
  ";
}
?>

</div>


</body>
</html>

