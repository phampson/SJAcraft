<?php
include('start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id']) && isset($_GET['frid'])){
        $friend_id = $_GET['frid'];
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
function update_newestmsg($user_id,$friend_id,$mysqli){
    $message_sql = 'select * from message where (sender='.$user_id.' and receiver='.$friend_id.') or (sender='.$friend_id.' and receiver = '.$user_id.') ORDER BY message_date DESC';
    $message_query = $mysqli->query($message_sql);
    if($newest_msg = $message_query->fetch_assoc()){
        $newest_msgid = $newest_msg['message_id'];
        $update_newest_sql = 'update friendlist set interact_msgid='.$newest_msgid.',newest_msgid='.$newest_msgid.' where user_id='.$user_id.' and friend_id='.$friend_id.';update friendlist set newest_msgid='.$newest_msgid.' where user_id='.$friend_id.' and friend_id='.$user_id.';';
        $mysqli->multi_query($update_newest_sql);
    }
}
update_newestmsg($user_id,$friend_id,$mysqli);
$fri_sql = 'select * from user_info where id="'.$_GET['frid'].'"';
if($fri_query = $mysqli->query($fri_sql)){
    $fri_fetch = $fri_query->fetch_assoc();
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
    $.post("sendmessage.php",{usid:<?php echo $user_id;?>,frid:Number(fid),msg:msg},function(){removeAllmessages();startNewchat(fid);});
}
function startNewchat(fri)
{
    friend_id = fri;
    var sendbox = '<div class="input-group">' +
                    '<input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />' +
                    '<span class="input-group-btn">' +
                    '<button id="sendBtn" type="submit" class="btn btn-primary btn-sm" sendto="'+fri+'" onclick = "sendMessage(this);">Send</button>' +
                    '</span>' +
                '</div>';
    
    document.getElementById("sendbox").innerHTML += sendbox;
    $.post("test.php",{usid:<?php echo $user_id;?>,frid:fri},function(data){
	oldData = data;
    });
    $.post("showmessage.php",{usid:<?php echo $user_id;?>,frid:fri},function(data){
	document.getElementById("messages").innerHTML += data;
	var messages = document.getElementById("messages");
	messages.scrollTop = messages.scrollHeight; 
	//setTimeout(startNewchat, 2500);
    });
    $("#message").scroll('100%');
    setInterval(updateData, 2500);
}
function updateData() {
    $.post("test.php",{usid:<?php echo $user_id;?>,frid:friend_id},function(data){
	newData = data;
	if (oldData != newData) {
		updatechat();
		oldData = newData;
    	}
    });
}
function updatechat()
{
    $.post("showmessage.php",{usid:<?php echo $user_id;?>,frid:friend_id},function(data){
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

<!--Message window -->

<div class="container">
    	<div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title" id = "friendtitle" ><span class="glyphicon glyphicon-comment"></span><?php echo $friendname;?>
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
<script>startNewchat(<?php echo $friend_id;?>);</script>
</html>
