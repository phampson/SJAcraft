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

<!-- CDN gallery -->
<h2 style="color: white; text-align: center;">Map Gallery</h2>
<br>
<center>
    <form action='dlc.php' method='get' onsubmit='encodeInput(this)'>
        <input type='text' name='searchTerm' placeholder="SEARCH TERM">
        <select name='sort'>
            <option disabled selected value>SORT BY</option>
            <option value='players'>players</option>
            <option value='uploader'>uploader</option>
            <option value='name'>name</option>
            <option value='date'>date</option>
        </select>
        <input type='submit' value='SEARCH'>
    </form>
</center>
<br>
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
        case "players":
            $sortOption = " ORDER BY num_players";
            break;
        case "uploader":
            $sortOption = " ORDER BY uploader";
            break;
        case "name":
            $sortOption = " ORDER BY display_name";
            break;
        case "date":
            $sortOption = " ORDER BY upload_date";
            break;
        default:
            $sortOption = "";
    }
} else {
    $sortOption = "";
}

if (isset($_GET["searchTerm"]) and $_GET["searchTerm"] != "" and $_GET["searchTerm"] != "SEARCH TERM") {
    $searchTerm = rawurldecode($_GET["searchTerm"]);
    
    
    $query = "SELECT id FROM user_info WHERE username='$searchTerm'";
    if ($id = $mysqli->query($query)) {
        $id = $id->fetch_assoc();
        $id = $id["id"];
    }
    $query = "SELECT * FROM map WHERE (display_name='$searchTerm' OR 
                      map_name='$searchTerm' OR uploader='$id') AND private=0";
} else {
    $query = "SELECT * FROM map WHERE private=0";
}

$query .= $sortOption;

if ($result = $mysqli->query($query)) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            echo "<div class='row'>";
        }
        $map_path      = $row['map_path'];
        $map_name      = $row['map_name'];
        $map_thumbnail = $row['map_thumbnail'];
        $numPlayers    = $row['num_players'];
        $displayName   = $row['display_name'];
        $uploaderID    = $row['uploader'];
        $userNameQuery = $mysqli->query("SELECT * FROM user_info WHERE id=$uploaderID");
        $uploaderName  = $userNameQuery->fetch_assoc();
        $uploaderName  = $uploaderName['username'];
        echo "
        <div class='col-sm-3'>
            <div class='thumbnail'>
                    <img src=$map_thumbnail alt=$map_name style='width:100%'>
                    <div class='caption'>
                        <p>$displayName</p>
                        <p>$numPlayers players</p>
                        <p>Uploaded by: <a href='../profile/profile.php?id=$uploaderID'>$uploaderName</a></p>
                    </div>
                <div style='text-align: center'><button><a href=$map_path download>Download</a></button></div>
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


       <!--<script type = "text/php" src="show_maps.php"></script>-->
        <div class="col-sm-3">
            <!--<div class="thumbnail" onclick="addMap()">-->
                <div class="thumbnail">
                <!--<a href="#"> -->
                    
                    <img src="../img/maps/plus.jpg" alt="Map1" style="width:100%">
                    <div class="caption">
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            Select map to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload"> 
                            <input type="submit" value="Upload Map" name="submit">
                    </form>
                    </div>
                </a>
            </div>
        </div>
    </div>


</body>
</html>