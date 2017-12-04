<?php
include('start.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql     = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query   = $mysqli->query($sql);
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
$message_sql   = 'select * from message';
$message_query = $mysqli->query($message_sql);
$message_rows  = $message_query->num_rows;
function ShowFriends($userid, $mysqli)
{
    $query = 'select * from friendlist where user_id= "' . $userid . '" and request = 1';
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $friend_id      = $row['friend_id'];
            $interact_msgid = $row['interact_msgid'];
            if ($interact_msgid == NULL) {
                $interact_msgid = 0;
            }
            $find_friend = 'select * from user_info where id = "' . $friend_id . '"';
            if ($friends = $mysqli->query($find_friend)) {
                $friend       = $friends->fetch_assoc();
                $friendname   = $friend['username'];
                $friendAvatar = $friend['avatar_path'];
                if (is_null($friendAvatar)) {
                    $picturePath = '../img/profpic.png';
                }
                else {
                    $picturePath = "../profile/$friendAvatar";
                }
            }
            echo '
                    <tbody class="container col-xs-12">
                    	<tr>
                    	<td style="width:6000px; height:50px;">
                        <div id="chatButton" style="float:left;">
                                <p><a href="../profile/profile.php?id=' . $friend_id . '"><img class="img-circle pull-left" style="width:37px;" style="height:37px;" src="' . $picturePath . '"></a>  
			<button style="color:white;" class="btn btn-link" id = ' . $friend_id . ' onclick=window.location.href="history.php?frid=' . $friend_id . '"><strong>' . $friendname . '</strong>
			</div>';
            $numNewMsg = 'select * from message where ((sender = "' . $userid . '" and receiver="' . $friend_id . '") or (sender = "' . $friend_id . '" and receiver = "' . $userid . '")) and message_id > "' . $interact_msgid . '"';
            if ($numNM = $mysqli->query($numNewMsg)) {
                $numM = $numNM->num_rows;
                if ($numM > 0) {
                    echo '
                                    <span class="redpoint">' . $numM . '</span>';
                }
            }
            echo '	<div style="float:right;">
                            <button style="background-color: green;" onclick=window.location.href="request.php?frid='.$friend_id.'&action=accept">
                            accept
                            </button><br>
                            <button class="btn-simple" style="background-color: red;" onclick=window.location.href="request.php?frid='.$friend_id.'&action=decline">
                            decline
                            </button>
			</div><br><br>
                            </p>
                        </div><hr>
                        </td>
                        </tr>
                    </tbody>
                    
                
';
            
        }
    }
    
    $query = 'select * from friendlist where user_id= "' . $userid . '" and request = 0';
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $friend_id      = $row['friend_id'];
            $interact_msgid = $row['interact_msgid'];
            if ($interact_msgid == NULL) {
                $interact_msgid = 0;
            }
            $find_friend = 'select * from user_info where id = "' . $friend_id . '"';
            if ($friends = $mysqli->query($find_friend)) {
                $friend       = $friends->fetch_assoc();
                $friendname   = $friend['username'];
                $friendAvatar = $friend['avatar_path'];
                if (is_null($friendAvatar)) {
                    $picturePath = '../img/profpic.png';
                } 
                else {
                    $picturePath = "../profile/$friendAvatar";
                }
            }
            echo '
                
                    <tbody class="col-xs-12">
                    	<tr>
                    	<td style="width:6000px; height:50px;">
                        <div id="chatButton">
                                <p><a href="../profile/profile.php?id=' . $friend_id . '"><img class="img-circle pull-left" style="width:37px;" style="height:37px;" src="' . $picturePath . '"></a>  
                            <button style="color:white;" class="btn btn-link" id = ' . $friend_id . ' onclick=window.location.href="history.php?frid=' . $friend_id . '">
                                
                                    <strong>' . $friendname . '</strong>';
            $numNewMsg = 'select * from message where ((sender = "' . $userid . '" and receiver="' . $friend_id . '") or (sender = "' . $friend_id . '" and receiver = "' . $userid . '")) and message_id > "' . $interact_msgid . '"';
            if ($numNM = $mysqli->query($numNewMsg)) {
                $numM = $numNM->num_rows;
                if ($numM > 0) {
                    echo '
                                    <span class="redpoint">' . $numM . '</span>';
                }
            }
            echo '
                                
                            </button>
                            </p>
                        </div><hr>
                        </td>
                        </tr>
                    </tbody>
                    
                
';
            
        }
    }
    
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
var friend_id;
var oldData;
var newData;
document.addEventListener("keyup", function(event) {
    event.preventDefault();
    if(event.which === 13) {
        document.getElementById("addfriendbtn").click();
        return false;
    }
    return true;
} );
function updateFriends()
{
}
function updateData() {
    var msg = "";
    var funct = "update";
    /*$.post("test.php",{usid:<?php
echo $user_id;
?>,frid:friend_id},function(data){
	newData = data;
	if (oldData != newData) {
		oldData = newData;
    	}
    });*/
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:friend_id, msg:msg, fnt:funct},function(data){
	newData = data;
	if (oldData != newData) {
		oldData = newData;
    	}
    });
}
function RemoveFriends()
{
    var oldFriendlist = document.getElementById("Frilist");
    while(oldFriendlist.hasChildNodes())
    {
        oldFriendlist.removeChild(oldFriendlist.firstChild);
    }
}
function newfriend()
{
    var msg = "";
    var funct = "newFriend";
    var friendname = document.getElementById("newfriname").value;
    document.getElementById("newfriname").value="";
    RemoveFriends();
    /*$.post("newfriend.php",{usid:<?php
echo $user_id;
?>,frnm:friendname},function(data){
document.getElementById("Frilist").innerHTML += data;});*/
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:friendname, msg:msg, fnt:funct},function(data){
window.location.reload();});
}
//setInterval(update, 2500);
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

<!--Message inbox -->
<div class="div1 col-sm-6 col-sm-offset-3" id="border-gold">
<h2 style="text-align: left;">Friend List</h2><hr>
    <div class="div1 col-sm-12">
            <div class="panel-heading">
                    <p style="color: black;">                   
                            <input type="text" placeholder="Search For Friends" id="newfriname">
                            <button id="addfriendbtn" class="btn-simple" type="submit" onclick="newfriend();">Add Friend</button>
                    </p>              
            </div><hr>
    </div>
    <table  id = "Frilist" class="table-condensed">
        <!-- Write php code to list friends -->
	<?php
	ShowFriends($user_id, $mysqli);
	?>
    </table><br>
</div>

</body>
</html>

