<?php
include("/home/ubuntu/ECS160WebServer/start.php");
function phpConsole($data) 
{
    $output = $data;
    if (is_array($output))
        $output = implode( ',', $output);
    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php

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
<div class="div1 col-xs-12 col-sm-8 col-sm-offset-2" id='border-gold'>
<h2><?php echo $mapRepoOwner."'s" ?> Map Repo</h2><hr>

<div class="col-sm-8 col-xs-12 col-sm-offset-2 col-xs-offset-0">

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
        <div class='col-sm-8 col-xs-7 col-sm-offset-2 col-xs-offset-0'>
            <div class='div2 thumbnail' style='overflow:auto;'>
                
                    <img src=$map_thumbnail alt=$map_name style='width:100%'>
                    <div class='caption'><h2>
                        <p><strong>$displayName</strong></p>
                        <p>$numPlayers players</p></h2>";
            if ($ownRepo==1) {
                echo "<p>Change public/private: </p>";
                echo "<input type='checkbox' name='$map_name"."[]' value='switch'>";
                echo "<p>Delete map: </p>";
                echo "<input type='checkbox' name='$map_name"."[]' value='delete'>";
                
                if ($private == true) {
                    echo "<br><p>Share with a friend only:</p>
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
              
                    echo "<br><p>Unshare with a friend: </p> <select name='$map_name"."[]' value='share'><option value='unshare'></option>";
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
                    
               <div style='text-align: center;'><br><h2><button class='btn-simple btn-sm'><a style='color:white' href=$map_path download>Download</a></button></h2></div>
            </div>
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

function showSharedMaps($query)
{
    $mysqli = $GLOBALS['mysqli'];
        if ($result = $mysqli->query($query) or die(mysqli_error($mysqli))) {
            $count = 0;
            while ($row = $result->fetch_assoc() or die(mysqli_error($mysqli))) {
                if($count % 4 == 0){
                    echo "<div class='row'>";       
                }
                
                $map_name = $row['map_name'];
                $uploader = $row['uploader'];

                phpConsole($map_name);
                phpConsole($uploader);

                $query_map = "select * from map where map_name='" . $map_name . "'AND uploader='" . $uploader . "'";

                $result_query_map = $mysqli->query($query_map) or die(mysqli_error($mysqli));
                $row_map = $result_query_map->fetch_assoc() or die(mysqli_error($mysqli));

                $map_path = "../dlc/".$row_map['map_path'];
                $map_name = $row_map['map_name'];
                $map_thumbnail = "../dlc/".$row_map['map_thumbnail'];
                $numPlayers = $row_map['num_players'];
                $displayName = $row_map['display_name'];
                $uploaderID = $row_map['uploader'];
                
                echo "
            <div class='col-sm-4 col-xs-8 col-sm-offset-0 col-xs-offset-2'>
                <div class='div2 thumbnail' style='overflow:auto;'>
                    
                        <p><i><img src=$map_thumbnail alt=$map_name style='width:100%'></i></p>
                        <div class='caption'><h2>
                            <p><strong>$displayName</strong></p>
                            <p>$numPlayers players</p></h2>";
            
                echo "  
                    		<div style='text-align: center;'><h2><button class='btn-simple btn-sm'><a style='color:white' href=$map_path download>Download</a></button></h2>
		</div>
                	</div>
                </div>
            </div>";
                if($count % 4 == 3){
                    echo "</div>";      
                }
                $count = $count + 1;
                
            }
        $row_map->close();
        $result->close();
    }
    
}

function displayUploadButton() 
{
    $mysqli = $GLOBALS["mysqli"];
    
        echo'
        <div class="row">
            <div class="col-sm-7 col-xs-8 col-xs-offset-0 col-sm-offset-3">
                <div class="div2 thumbnail" style="overflow:auto;">
                    
                    <p><i><img src="../img/maps/plus.jpg" alt="Map1" style="width:100%"></i></p>
                    <center><div class="caption">
                        <form action="upload.php" method="post" enctype="multipart/form-data"><p>
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
        echo '              </select> 
                            <h2><input class="btn-simple btn-sm" type="submit" value="Upload Map" name="submit"></h2>
                      </p></form>
                    </div></center>
                    </a>
                </div>
            </div>
        </div>';
}
if ($viewingOwnRepo) {
    displayUploadButton();
    echo "<form method='post' action='changemapsettings.php' class='col-x'>";
    echo"<div class='row'>";
    echo "<h2>Public Repo</h2><hr>";
    $query = "select * from map where uploader = $user_id and private=0";
    showMaps($query,1,false);
    echo "</div>";
    echo"<div class='row'>";
    echo "<h2>Private Repo</h2><hr>";
    $query = "select * from map where uploader = $user_id and private=1";
    showMaps($query,1,true);
    echo "</div>,";
    echo "<h2><input class='btn-simple btn-sm' type='submit' value='Apply Map Changes'></h2>";
    echo "</form>";
} else {
    echo"<div class='row'>";
    echo "<h2>Public Repo</h2><hr>";
    $query = "select * from map where uploader=$user_id and private=0";
    showMaps($query,0,false);
    echo "</div>";
    echo"<div class='row'>";
    echo "<h2>Private Repo</h2><hr>";
    //TODO GET MAPS THAT ARE SHARED
    $usr_id =$_SESSION["user_id"];
    $repo_id = $user_id;
    phpConsole($repo_id);
    phpConsole($usr_id);
    $query = "select * from map_settings where uploader=$repo_id AND shared_user=$usr_id";
    showSharedMaps($query);
    echo "</div>,";
}
        
?>

</div>
</body>
