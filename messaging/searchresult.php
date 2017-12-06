<?php
include('start.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
if (isset($_SESSION['user_id']) && isset($_GET['frid'])) {
    $friend_id = $_GET['frid'];
    $user_id   = $_SESSION['user_id'];
    $sql       = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query     = $mysqli->query($sql);
    if ($query) {
        $fetch    = $query->fetch_assoc();
        $username = $fetch['username'];
        $navpath  = "../navbar/navbarlogged.html";
    }
} 
else {
    header("Location: ../index.php");
    exit();
}

$fri_sql = 'select * from user_info where id="' . $friend_id . '"';
if ($fri_query = $mysqli->query($fri_sql)) {
    $fri_fetch  = $fri_query->fetch_assoc();
    $friendname = $fri_fetch['username'];
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
        <script type = "text/javascript">
function removeAllmessages()
{
    var div = document.getElementById("messages");
    while(div.hasChildNodes())
    {
        div.removeChild(div.firstChild);
    }
}

function sendkeyword()
{
    var msg = document.getElementById("btn-input").value;
    document.getElementById("btn-input").value = "";
    $.post("searchmessage.php",{usid:<?php
echo $user_id;
?>,frid:<?php
echo $friend_id;
?>,msg:msg},function(data){document.getElementById("messages").innerHTML += data;});
}

        </script>
</head>
<body>
<!-- Nav Bar -->
<div id="navbar"></div>
<?php
echo "<script>\n";
echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<!--Message window -->

<div class="container">
    	<div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title" id = "friendtitle" style="color:white" >Searching message history with <?php
echo $friendname;
?>
                </div>
                <button id="backbtn" class="btn" type="button" onclick="window.location.href='history.php?frid=<?php
echo $friend_id;
?>';">Back</button>
            </div>

            <div id="messages" class="panel-body msgContainerBase2">

            </div>
            <div id = "searchbox" class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your keywords here..." />
                    <span class="input-group-btn">
                    <button id="searchBtn" type="submit" class="btn btn-primary btn-sm" onclick = "removeAllmessages();sendkeyword();">Search</button>
                    </span>
                </div>
            </div>
		</div>
    </div>
</div>

</body>
</html>
