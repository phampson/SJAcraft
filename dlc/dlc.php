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
<div class="div1 col-xs-12 col-sm-8 col-xs-offset-0 col-sm-offset-2" id="border-gold">
<h2>Map Gallery</h2><hr>
<center>
    <h2>
    <form action='dlc.php' method='get' onsubmit='encodeInput(this)'>
   	    <input class='input-sm' type='text' name='searchTerm' style='color:black;' placeholder="Search Term">
        <input class='btn-simple btn-sm' type='submit' value='SEARCH'>
        <select name='sort' class='btn-sm' style='color:black'>
            <option disabled selected value>SORT BY</option>
            <option value='players'>players</option>
            <option value='uploader'>uploader</option>
            <option value='name'>name</option>
            <option value='date'>date</option>
        </select>
    </form>
    </h2>
</center>
<hr>
<script type='text/javascript'>
    function encodeInput(form)
    {
        form.elements['searchTerm'].value = encodeURIComponent(form.elements['searchTerm'].value);
    }
</script>

<div class="col-sm-12 col-sm-offset-1 col-md-8 col-md-offset-2">


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
} 
else {
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
} 
else {
    $query = "SELECT * FROM map WHERE private=0";
}
?>
</div>
<?php
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
        //$uploaderName="ss";
        echo "
        <div class='col-sm-3 col-xs-12 col-xs-offset-0 col-sm-offset-0'>
        <h2>
            <div class='div2 thumbnail' style='overflow:auto;'>
                    <p><i><img src=$map_thumbnail alt=$map_name style='width:100%'></i></p>
                    <div class='caption'>
                        <p><strong>$displayName</strong></p>
                        <p>$numPlayers players </p>
                        <p>Uploaded by: <a  style='color:white;' href='../profile/profile.php?id=$uploaderID'>$uploaderName</a></p>
                    </div>
                <center><button class='btn-simple btn-sm'><a  style='color:white;' href=$map_path download>Download</a></button></center>
            </div>
            </h2>
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
        <div class="col-sm-12 col-xs-12 "><br>
            <!--<div class="thumbnail" onclick="addMap()">-->
                <div class='div2 thumbnail' style='overflow:auto;'>
                <!--<a href="#"> -->
                    
                   
                    <center><div class="caption">
                        <form action="upload.php" method="post" enctype="multipart/form-data"><p>
                            Select map to upload:
                            <input type="file" name="fileToUpload" id="fileToUpload"></p><h2>
                           <input class='btn-simple btn-sm' type="submit" value="Upload Map" name="submit"></h2>
                    </form>
                    </div></center>
                </a>
            </div>
        </div>
    </div>


</body>
<script src="../login/black.js"></script>
<script>
//console.log("asaa");
var error=getAllUrlParams().error;
console.log(window.location.href);
if (error=='0')
{
	alert("Sorry, file format incorrect");
}
if (error=='1')
{
	alert("Sorry, file already exists");
}
if (error=='2')
{
	alert("Sorry, your file is too large");
}   
if (error=='3')
{
	alert("Sorry, your file was not uploaded");
}  
if (error=='4')
{
	alert("Uploading succeeded");
}  
if (error=='5')
{
	alert("Uploading failed");
}
if (error=='6')
{
	alert("Unknown error");
} 
  
    
</script>
</html>
