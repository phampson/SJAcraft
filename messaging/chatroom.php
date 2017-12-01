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
    $query = 'select friend_id from friendlist where user_id= "' . $userid . '"';
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $friend_id   = $row['friend_id'];
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
                <div >
                    
                        <div id="chatButton">
                                <a href="../profile/profile.php"><img class="img-circle pull-left" style="width:45px;" style="height:45px;" src="' . $picturePath . '"></a>  
                            <button class="btn btn-link" id = ' . $friend_id . ' onclick="removeAllmessages();startNewchat(this.id)">
                                <div class="messages">
                                    <strong>' . $friendname . '</strong>
                                </div>
                            </button></p>
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
        document.getElementById("sendBtn").click();
        return false;
    }
    return true;
} );

function update()
{
    removeAllmessages();
    updatechat(friend_id);
}

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
    $.post("sendmessage.php",{usid:<?php
echo $user_id;
?>,frid:Number(fid),msg:msg},function(){removeAllmessages();startNewchat(fid);});
}

function sendAttachment(frid)
{
    var attach = document.getElementById("btn-input").value;
    var fid = frid.getAttribute('sendto');
    var msg = "";
    document.getElementById("btn-input").value = "";
    $.post("attachment.php",{usid:<?php
echo $user_id;
?>,frid:Number(fid),attach:attach},function(data){msg = data;});
    $.post("sendmessage.php",{usid:<?php
echo $user_id;
?>,frid:Number(fid),msg:msg},function(){removeAllmessages();startNewchat(fid);});
}

function startNewchat(fri, msgcnt)
{
    friend_id = fri;

    var sendbox = '<div class="input-group">' +
                    '<div class="selectimg container">' +
                    '<?php if(!isset($_GET[\'id\'])): ?>' +
 	            '<form action="uploadProfile.php" method="post" enctype="multipart/form-data">' +
	            '<upload><font color ="white" >Select image to upload:</upload>' +
	            '<input type="file" name="fileToUpload" id="fileToUpload"></font>' +
	            '<input type="submit" value="Upload Image" name="submit">' +
                    '</form>' +
                    '<?php endif; ?>' +
                    '</div>' +
                    '<input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />' +
                    '<span class="input-group-btn">' +
                    '<button id="sendBtn" type="submit" class="btn btn-primary btn-sm" sendto="'+fri+'" onclick = "sendMessage(this);">Send</button>' +
                    '</span>' +
                '</div>';
    
    document.getElementById("sendbox").innerHTML += sendbox;
    $.post("test.php",{usid:<?php
echo $user_id;
?>,frid:fri},function(data){
	oldData = data;
    });
    $.post("showmessage.php",{usid:<?php
echo $user_id;
?>,frid:fri},function(data){
	document.getElementById("messages").innerHTML += data;
	var messages = document.getElementById("messages");	
	if (msgcnt != undefined) {
	    $("#message").scrollTop($("*:contains('" + msgcnt + "'):last").offset().top);
	}	
	else {
	    messages.scrollTop = messages.scrollHeight;
	}	
	//setTimeout(startNewchat, 2500);
    });
    //$("#message").scroll('100%');
    setInterval(updateData, 2500);
}
function updateData() {
    $.post("test.php",{usid:<?php
echo $user_id;
?>,frid:friend_id},function(data){
	newData = data;
	if (oldData != newData) {
		updatechat();
		oldData = newData;
    	}
    });
}

function updatechat()
{
    $.post("showmessage.php",{usid:<?php
echo $user_id;
?>,frid:friend_id},function(data){
	var div = document.getElementById("messages");
    	while(div.hasChildNodes())
    	{
        	div.removeChild(div.firstChild);
    	}	
	document.getElementById("messages").innerHTML += data;
	var messages = document.getElementById("messages");
	messages.scrollTop = messages.scrollHeight; 
    });
    $("#message").scroll('100%');
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
    $.post("newfriend.php",{usid:<?php
echo $user_id;
?>,frnm:friendname},function(data){
document.getElementById("Frilist").innerHTML += data;});

}

function messageSearch(searchType)
{
    var mesSearch = document.getElementById("mesSearch").value;
    document.getElementById("mesSearch").value="";

    if (mesSearch != "" || searchType == "back") {
        var oldFriendlist = document.getElementById("Frilist");
        while(oldFriendlist.hasChildNodes())
        {
            oldFriendlist.removeChild(oldFriendlist.firstChild);
        }
        $.post("messageSearch.php",{usid:<?php
echo $user_id;
?>,msgSrch:mesSearch,type:searchType},function(data){
document.getElementById("Frilist").innerHTML += data;});    
    }
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


<div class = "container-fluid">
    <div class = "panel panel-default">
	<div class = "panel-heading topBar">
		<h2 class= "panel-title">Chat Room</h2>
	</div>
	<div class="panel-body msgContainerBase2" style="overflow:scroll">
		<div class="panel-group">
		<!--Message inbox -->
		<div class = "container">
		    <div id = "inbox" class = "topleft">
			<div class = "panel panel-default">
			    <div class= "panel-heading topBar">
				<div>
				    <h3 class = "panel-title">
				        <span class = "glyphicon glyphicon-message-in">
				        </span> Friends List<br>
				            <input type="text" id="mesSearch">
				            <button class="btn" type="submit" onclick="removeAllmessages();messageSearch('message')">Search Messages</button> 
                                            <button class="btn" type="submit" onclick="removeAllmessages();messageSearch('back')">Back</button>
				    </h3>
				</div>
			    </div>
			    <div class = "panel-body msgContainerBase1">
				<div id="Frilist" class = "panel-group">
				<!-- Write php code to list friends -->
				<?php
ShowFriends($user_id, $mysqli);
?>
				</div>
			    </div>
			</div>
		    </div>
		</div>

		<!--Message window -->

		<div class="container" id="chat_window_1">
		    <div class="topright">
		    	<div class="panel panel-primary">
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
	    </div>
	</div>
    </div>
</div>




</body>
</html>
