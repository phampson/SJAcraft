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

function ShowFriends($userid,$mysqli) {
    $query = 'select friend_id from friendlist where user_id= "'.$userid.'"';
    if ($result = $mysqli->query($query)){
        while($row = $result->fetch_assoc()){
            $friend_id = $row['friend_id'];
            $find_friend = 'select username from user_info where id = "'.$friend_id.'"';
            if ($friends = $mysqli->query($find_friend)){
                $friend = $friends->fetch_assoc();
                $friendname = $friend['username'];
            }
            echo '
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" id = '.$friend_id.' onclick="removeAllmessages();startNewchat(this.id)">
                                <div class="messages">
                                    <strong>'.$friendname.'</strong>
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
function removeAllmessages()
{
    var div = document.getElementById("messages");
    while(div.hasChildNodes())
    {
        div.removeChild(div.firstChild);
    }
    var sen = document.getElementById("sendbox");
    while(sen.hasChildNodes())
    {
        sen.removeChild(sen.firstChild);
    }
}

function sendMessage(frid)
{
    var msg = document.getElementById("btn-input").value;
    var fid = frid.getAttribute('sendto');
    document.getElementById("btn-input").value = "";
    $.post("sendmessage.php",{usid:<?php echo $user_id;?>,frid:Number(fid),msg:msg},function(){removeAllmessages();startNewchat(fid);});
}

function startNewchat(fri)
{
    var sendbox = '<div class="input-group">' +
                    '<input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />' +
                    '<span class="input-group-btn">' +
                    '<button type="submit" class="btn btn-primary btn-sm" sendto="'+fri+'" onclick = "sendMessage(this);">Send</button>' +
                    '</span>' +
                '</div>';
    document.getElementById("sendbox").innerHTML += sendbox;
    $.post("showmessage.php",{usid:<?php echo $user_id;?>,frid:fri},function(data){
document.getElementById("messages").innerHTML += data;});
    $("#message").scroll('100%');
    //var div = document.getElementById("message");
    //div.scrollIntoView();
}

function newfriend()
{
    var friendname = document.getElementById("newfriname").value;
    document.getElementById("newfriname").value="";

    
    var oldFriendlist = document.getElementById("Frilist");
    while(oldFriendlist.hasChildNodes())
    {
        oldFriendlist.removeChild(oldFriendlist.firstChild);
    }
    $.post("newfriend.php",{usid:<?php echo $user_id;?>,frnm:friendname},function(data){
document.getElementById("Frilist").innerHTML += data;});
 
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

<!--Message inbox -->
<div class = "container">
    <div id = "inbox" class = "topleft">
        <div class = "panel panel-default">
            <div class= "panel-heading topBar">
                <div>
                    <h3 class = "panel-title">
                        <span class = "glyphicon glyphicon-message-in">
                        </span> Friends list<br>
                            <input type="text" id="newfriname">
                            <button class="btn" type="submit" onclick="newfriend();">Search</button>
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

<!--Message window -->

<div class="container">
    <div id="chat_window_1" class="topright">
    	<div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title" id = "friendtitle" ><span class="glyphicon glyphicon-comment"></span><!-- php code to display current friend -->
                </div>
            </div>

            <div id="messages" class="panel-body msgContainerBase2">
            <!-- PHP code write here -->
            </div>
            <div id = "sendbox" class="panel-footer">
            </div>
		</div>
    </div>
</div>


</body>
</html>
