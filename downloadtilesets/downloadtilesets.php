<?php
include('/home/ubuntu/ECS160WebServer/start.php');
if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
} 
else {
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

<!-- CDN gallery -->
<h2 style="color: white; text-align: center;">Tilesets Gallery</h2>

<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
<?php
$query = "select * from tilesets";

if ($result = $mysqli->query($query)) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            echo "<div class='row'>";
        }
        $tileset_path = $row['tileset_path'];
        $tileset_name = $row['tileset_name'];
        //$displayName = $row['display_name'];
        $uploaderID   = $row['uploader'];
        
        $userNameQuery = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
        $uploaderName  = $userNameQuery->fetch_assoc();
        $uploaderName  = $uploaderName['username'];
        
        echo "
                <div class='col-sm-3'>
                    <div class='thumbnail'>
                        <img src='tilesets/" . $tileset_name . "' alt='should be replaced with tileset preview thumbnail' style='width:100%'>
                        <div class='caption'>
                            <p style='color:black;'>$tileset_name</p>
                            <p style='color:black;'>Uploaded by: <a href='../profile/profile.php?id=$uploaderID'>$uploaderName</a></p>
                        </div>
                    <div style='text-align: center'>";
        echo "
                        <button><a href=$tileset_path download>Download</a></button>
                    </div>
                </div>
        
                </div>";
        /*
        echo "
        <div class='col-sm-3'>
        <div class='thumbnail'>
        <img src='soundpkg/soundPic.png' alt='should be replaced with tileset preview thumbnail' style='width:100%'>
        <div class='caption'>
        <p>$tileset_name</p>
        <p>Uploaded by: $uploaderName</p>
        </div>
        <div style='text-align: center'>";
        echo "
        <button><a href=$tileset_path download>Download</a></button>
        </div>
        </div>
        
        </div>";
        */
        
        if ($count % 4 == 3) {
            echo "</div>";
        }
        $count = $count + 1;
    }
    $result->close();
}
?>    
<!--<script type = "text/php" src="show_maps.php"></script>-->
        <div class="col-sm-3">
            <!--<div class="thumbnail" onclick="addMap()">-->
                <div class="thumbnail">
                <!--<a href="#"> -->
                    
                    <img src="../img/maps/plus.jpg" alt="Map1" style="width:100%">
                    <div class="caption">
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            Select tileset to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload"> 
                            <input type="submit" value="Upload Image" name="submit">
                    </form>
                    </div>
                </a>
            </div>
        </div>
</div>


</body>
<script type="text/javascript" src="cdn.js"></script>
</html>
