<?php
include('start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
	$sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);
	if ($query) {
		$fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$navpath = "../navbar/navbarlogged.html";	
	}
}
else {
    header("Location: ../index.php");
    exit();
}
$message_sql = 'select * from message';
$message_query = $mysqli->query($message_sql);
$message_rows = $message_query->num_rows;

function ShowFriends($userid,$mysqli) {
    $query = 'select * from friendlist where user_id= "'.$userid.'"';
    if ($result = $mysqli->query($query)){
        while($row = $result->fetch_assoc()){
            $friend_id = $row['friend_id'];
            $interact_msgid = $row['interact_msgid'];
            if($interact_msgid == NULL){
                $interact_msgid = 0;
            }
            $find_friend = 'select * from user_info where id = "'.$friend_id.'"';
            if ($friends = $mysqli->query($find_friend)){
                $friend = $friends->fetch_assoc();
                $friendname = $friend['username'];
		$friendAvatar = $friend['avatar_path'];
		if (is_null($friendAvatar)) {
			$picturePath = '../img/profpic.png';
		}
		else {
			$picturePath = "../profile/$friendAvatar";
		}
            }
            echo '
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                                <a href="../profile/profile.php?id='.$friend_id.'"><img class="img-circle pull-left" style="width:45px;" style="height:45px;" src="'.$picturePath.'"></a>  
                            <button class="btn btn-link" id = '.$friend_id.' onclick=window.location.href="history.php?frid='.$friend_id.'">
                                <div class="messages">
                                    <strong>'.$friendname.'</strong>';
            $numNewMsg = 'select * from message where ((sender = "'.$userid.'" and receiver="'.$friend_id.'") or (sender = "'.$friend_id.'" and receiver = "'.$userid.'")) and message_id > "'.$interact_msgid.'"';
            if($numNM = $mysqli->query($numNewMsg)){
                $numM = $numNM->num_rows;
                if($numM>0){
                    echo '
                                    <span class="redpoint">'.$numM.'</span>';
                }
            }
            echo '
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
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

document.addEventListener("keyup", function(event) {
    event.preventDefault();
    if(event.which === 13) {
        document.getElementById("sendBtn").click();
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
    /*$.post("test.php",{usid:<?php echo $user_id;?>,frid:friend_id},function(data){
	newData = data;
	if (oldData != newData) {
		oldData = newData;
    	}
    });*/
    $.post("messaging.php",{usid:<?php echo $user_id;?>,frid:friend_id, msg:msg, fnt:funct},function(data){
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

    /*$.post("newfriend.php",{usid:<?php echo $user_id;?>,frnm:friendname},function(data){
document.getElementById("Frilist").innerHTML += data;});*/

    $.post("messaging.php",{usid:<?php echo $user_id;?>,frnm:friendname, msg:msg, fnt:funct},function(data){
document.getElementById("Frilist").innerHTML += data;});
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
<div class = "container-fluid">
    <div id = "inbox" class = "panel panel-default">
            <div class= "panel-heading topBar">
                <div>
                    <h3 class = "panel-title">
                        <span class = "glyphicon glyphicon-message-in">
                        </span> Friends list<br>
                            <input type="text" id="newfriname">
                            <button id="addfriendbtn" class="btn" type="submit" onclick="newfriend();">Add Friend</button>
                    </h3>
                </div>
            </div>
            <div class = "panel-body msgContainerBase1">
                <div id="Frilist" class = "panel-group">
                <!-- Write php code to list friends -->
		<?php ShowFriends($user_id,$mysqli);?>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
