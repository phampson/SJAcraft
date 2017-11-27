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

<!-- Sound Package gallery -->
<h2 style="color: white; text-align: center;">Sound Packages Gallery</h2>

<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

<?php
$query = "select * from soundpkgs";

if ($result = $mysqli->query($query)) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            echo "<div class='row'>";
        }
        $soundpkg_path = $row['soundpkg_path'];
        $soundpkg_name = $row['soundpkg_name'];
        //$displayName = $row['display_name'];
        $uploaderID    = $row['uploader'];
        
        $userNameQuery = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
        $uploaderName  = $userNameQuery->fetch_assoc();
        $uploaderName  = $uploaderName['username'];
        echo "
                <div class='col-sm-3'>
                    <div class='div1 thumbnail'>
                        <img src='soundpkg/soundPic.png' alt='I hate bugs, yes I do' style='width:100%'>
                        <div class='caption'>        
                            <audio id='$count'>
                                <source src='soundpkg/$soundpkg_name'>
                            </audio>
                            <p>$soundpkg_name</p>
                            <p>Uploaded by: <a href='../profile/profile.php?id=$uploaderID'>$uploaderName</a></p>
                        </div>
                    <div style='text-align: center'>";
        echo '
                        <button onclick="document.getElementById(\'' . $count . '\').play()">Play</button>
                        <button onclick="document.getElementById(\'' . $count . '\').pause()">Pause</button>
                        <button onclick="document.getElementById(\'' . $count . '\').pause(); document.getElementById(\'' . $count . '\').currentTime = 0;">Stop</button>

                        ';
        echo "
                        <button><a href=$soundpkg_path download>Download</a></button>
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

    <!-- Block to upload sound packages -->
    <div class="col-sm-3">
        <div class="thumbnail">
            <img src="../img/maps/plus.jpg" alt="Insert Sound" style="width:100%">
            <div class="caption">
                <!-- Form that calls upload.php -->
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    Select sound package to upload:
                    <input type="file" name="fileToUpload" id="fileToUpload"> 
                    <input type="submit" value="Upload Package" name="submit">
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
