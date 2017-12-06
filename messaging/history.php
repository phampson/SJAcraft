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
    


("Location: ../index.php");
    exit();
}

if (isset($_GET['mid'])) {
    $mid = '"#' . $_GET['mid'] . '"';
} 
else {
    $mid = '"#"';
}

function update_newestmsg($user_id, $friend_id, $mysqli)
{
    //messaging email digest
    exec("nohup php ../digest/digestTest.php 2>&1 $friend_id &", $output, $return);


    $message_sql   = 'select * from message where (sender=' . $user_id . ' and receiver=' . $friend_id . ') or (sender=' . $friend_id . ' and receiver = ' . $user_id . ') ORDER BY message_date DESC';
    $message_query = $mysqli->query($message_sql);
    if ($newest_msg = $message_query->fetch_assoc()) {
        $newest_msgid      = $newest_msg['message_id'];
	
        //messaging email digest
        exec("nohup php ../digest/smartDigest2.php 2>&1 $friend_id &", $output, $return);
     
        //rest of update
        $update_newest_sql = 'update friendlist set interact_msgid=' . $newest_msgid . ',newest_msgid=' . $newest_msgid . ' where user_id=' . $user_id . ' and friend_id=' . $friend_id . ';update friendlist set newest_msgid=' . $newest_msgid . ' where user_id=' . $friend_id . ' and friend_id=' . $user_id . ';';
        $mysqli->multi_query($update_newest_sql);
    }
}

$fri_sql = 'select * from user_info where id="' . $friend_id . '"';
if ($fri_query = $mysqli->query($fri_sql)) {
    $fri_fetch  = $fri_query->fetch_assoc();
    $friendname = $fri_fetch['username'];
}
update_newestmsg($user_id, $friend_id, $mysqli);
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
    var funct = "sendMessage";
    document.getElementById("btn-input").value = "";
    //$.post("sendmessage.php",{usid:<?php
echo $user_id;
?>,frid:Number(fid),msg:msg},function(){removeAllmessages();startNewchat(fid);});
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:Number(fid),msg:msg,fnt:funct},function(){removeAllmessages();startNewchat(fid);});
}
function startNewchat(fri)
{
    friend_id = fri;
    var msg = "";
    var funct = "update";
    var sendbox = '<div class="panel panel-default">' + '<div class="panel-footer">' + '<div class="input-group">' +
 	        '<form action="attachment.php?frid='+fri+'" method="post" enctype="multipart/form-data">' +
	            '<upload><font color ="white">Add Attachment</upload>' +
	            '<input type="file" name="fileToUpload" id="fileToUpload"></font>' +
	            '<h2><input type="submit" class="btn-simple btn-sm" value="Upload file" name="submit"></h2>' +
                               
                '<div class="input-group">' +
                 '<p>' +
                    '<textarea style="color:black;" id="btn-input" name="message" placeholder="Write your message here..."></textarea>' + '</p>' +
                    '<span class="input-group-btn">' + '<h2>' +
                    '<button id="sendBtn" type="submit" class="btn-simple btn-sm pull-right" sendto="'+fri+'" onclick = "sendMessage(this);">Send</button>' + 
               '</h2>' +   
              '</span>' + 
              '</form>'+  
              '</div>' +
              '</div>' + 
              '</div>' + 
              '</div>';
    
    document.getElementById("sendbox").innerHTML += sendbox;
    /*$.post("test.php",{usid:<?php
echo $user_id;
?>,frid:fri},function(data){
	oldData = data;
    });
    $.post("showmessage.php",{usid:<?php
echo $user_id;
?>,frid:fri},function(data){
	document.getElementById("messages").innerHTML += data;
	var messages = document.getElementById("messages");
	messages.scrollTop = messages.scrollHeight; 
	//setTimeout(startNewchat, 2500);
    });*/
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:fri,msg:msg,fnt:funct},function(data){
	oldData = data;
    });
    funct = "showMessage";
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:fri,msg:msg,fnt:funct},function(data){
	document.getElementById("messages").innerHTML += data;
	var messages = document.getElementById("messages");
	messages.scrollTop = messages.scrollHeight; 
	//setTimeout(startNewchat, 2500);
    });
    $("#message").scroll('100%');
    setInterval(updateData, 2500);
}
function updateData() {
    var msg = "";
    var funct = "update";
    /*$.post("test.php",{usid:<?php
echo $user_id;
?>,frid:friend_id},function(data){
	newData = data;
	if (oldData != newData) {
		updatechat();
		oldData = newData;
    	}
    });*/
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:friend_id,msg:msg,fnt:funct},function(data){
	newData = data;
	if (oldData != newData) {
		updatechat();
		oldData = newData;
    	}
    });
}
function updatechat()
{
    var msg = "";
    var funct = "showMessage";
    /*$.post("showmessage.php",{usid:<?php
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
    });*/
    $.post("messaging.php",{usid:<?php
echo $user_id;
?>,frid:friend_id,msg:msg,fnt:funct},function(data){
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

<div class="div1 col-sm-8 col-sm-offset-2" id="border-gold">
<h2>Chat Room</h2>
    	<div class="panel panel-default">
            <div class="panel-heading">
                <h2>
                    <div class="panel-title" style="color: white;" id = "friendtitle" ><span class="glyphicon glyphicon-comment"></span>  Your Conversation with <?php
echo $friendname;
?>
                <button id="backbtn" class="btn-simple pull-right" type="button" onclick="window.location.href='friendslist.php';">Back</button>
                <button id="ssearchbtn" class="btn-simple pull-right" type="button" onclick="window.location.href='searchresult.php?frid=<?php
echo $friend_id;
?>';">Search</button>               
            		</div>
            	</h2>
            	<?php $isfriend = $mysqli->query("select * from friendlist where user_id=".$friend_id." and friend_id=".$user_id.";");
            	      if (is_object($isfriend) && $isfriend->num_rows){
            	          $friend_req = $isfriend->fetch_assoc();
            	          if($friend_req['request']==1){
            	              echo "<br> <font color = 'red'>This person has not accepted your friend request. Your message(s) may not be delivered.</font>";
            	          }
            	      }
            	?>
           	</div>
				
            <div id="messages" class="div2 col-xs-12">
            <!-- PHP code write here -->
            </div>
            <div>
            	<div id = "sendbox">
            	</div>
            </div>
		</div>
    </div>
</div>


</body>
<script>
startNewchat(<?php
echo $friend_id;
?>);
location.href = <?php
echo $mid;
?>;
</script>
<script>
var mid = <?php
echo $mid;
?>;
if (mid != '#')
{
    location.href = mid;
}
</script>
</html>
