<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
$msg  = $_POST["msg"];
$fnt  = $_POST["fnt"];
include('/home/ubuntu/ECS160WebServer/start.php');


function update_newestmsg($user_id, $friend_id, $mysqli)
{
    $message_sql   = 'select * from message where (sender=' . $user_id . ' and receiver=' . $friend_id . ') or (sender=' . $friend_id . ' and receiver = ' . $user_id . ') ORDER BY message_date DESC';
    $message_query = $mysqli->query($message_sql);
    if ($newest_msg = $message_query->fetch_assoc()) {
        $newest_msgid      = $newest_msg['message_id'];
        $update_newest_sql = 'update friendlist set interact_msgid=' . $newest_msgid . ',newest_msgid=' . $newest_msgid . ' where user_id=' . $user_id . ' and friend_id=' . $friend_id . ';update friendlist set newest_msgid=' . $newest_msgid . ' where user_id=' . $friend_id . ' and friend_id=' . $user_id . ';';
        $mysqli->multi_query($update_newest_sql);
    }
}

function getNumRows($friend_id, $user_id)
{
    global $mysqli;
    $query = 'SELECT * FROM message WHERE (sender = "' . (int) $user_id . '" AND receiver = ' . $friend_id . ') OR (sender = ' . $friend_id . ' AND receiver = "' . (int) $user_id . '")';
    if ($result = $mysqli->query($query)) {
        echo $result->num_rows;
    }
}

function DisplayMessage($friend_id, $user_id)
{
    global $mysqli;
    $query = 'SELECT * FROM message WHERE (sender = "' . (int) $user_id . '" AND receiver = ' . $friend_id . ') OR (sender = ' . $friend_id . ' AND receiver = "' . (int) $user_id . '")';
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $content  = $row['message_content'];
            $receiver = $row['receiver'];
            $date     = $row['message_date'];
            $msgid    = $row['message_id'];
            $sql      = 'SELECT * FROM user_info WHERE id = "' . (int) $user_id . '"';
            $qry      = $mysqli->query($sql);
            $myrow    = $qry->fetch_assoc();
            $myname   = $myrow['username'];
            $myAvatar = $myrow['avatar_path'];
            if (is_null($myAvatar)) {
                $myPicturePath = "../img/profpic.png";
            } 
            else {
                $myPicturePath = "../profile/$myAvatar";
            }
            $sql          = 'SELECT * FROM user_info WHERE id = "' . (int) $friend_id . '"';
            $qry          = $mysqli->query($sql);
            $friendrow    = $qry->fetch_assoc();
            $friendname   = $friendrow['username'];
            $friendAvatar = $friendrow['avatar_path'];
            $regex        = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»????]))@';
            
            if (is_null($friendAvatar)) {
                $friendPicturePath = "../img/profpic.png";
            } 
            else {
                $friendPicturePath = "../profile/$friendAvatar";
            }
            if ($receiver == $friend_id) {
                echo "
		<div class='row msgContainer base_sent'>
                    <div class='col-md-10 col-xs-10'>
                        <div id='$msgid' class='messages msg_sent'>";
                if (preg_match("/^attachment_files\/.*/", $content, $matches) || preg_match($regex, $content, $matches)) {
                    echo "
                         <p><a href='$content'>$content</a></p>";
                } 
                else {
                    echo "<p style='word-wrap:break-word'>$content</p>";
                }
                echo "
                         
				<br>
                            <time>$myname | $date</time>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-2 avatar'>
                        <img class='img-circle' src='$myPicturePath' style='width:65px;' style='height:65px'>
                    </div>
                </div>
				";
            } 
            else {
                echo "
		<div class='row msgContainer base_receive'>
                    <div class='col-md-2 col-xs-2 avatar'>
                        <img class='img-circle' src='$friendPicturePath' style='width:65px;' style='height:65px'>
                    </div>
                    <div class='col-xs-10 col-md-10'>
                        <div id='$msgid' class='messages msg_receive'>";
                if (preg_match("/^attachment_files\/.*/", $content, $matches) || preg_match($regex, $content, $matches)) {
                    echo "
                         <p><a href='$content'>$content</a></p>";
                } 
                else {
                    echo "<p style='word-wrap:break-word'>$content</p>";
                }
                echo "
                           
                            <time>$friendname | $date</time>
                        </div>
                    </div>
                </div>";
            }
        }
    }
    
}

function addFriend($frnm, $user_id)
{
    $mysqli = $GLOBALS["mysqli"];
    
    $findnewfriendid = 'select id from user_info where username  = "' . $frnm . '"';
    $trynewfriend    = $mysqli->query($findnewfriendid);
    if ($trynewfriend->num_rows > 0) {
        $ro        = $trynewfriend->fetch_assoc();
        $friend_id = $ro['id'];
        $notfriend = 'select * from friendlist where (user_id = "' . (int) $user_id . '" and friend_id = "' . $friend_id . '") or (user_id = "' . $friend_id . '" and friend_id = "' . (int) $user_id . '")';
        $isfriend  = $mysqli->query($notfriend);
        if ($isfriend->num_rows == 0 and $user_id != $friend_id) {
            $addnewfriend = 'insert into friendlist (user_id,friend_id) value ("' . (int) $user_id . '","' . $friend_id . '");insert into friendlist (user_id,friend_id,request) value ("' . $friend_id . '","' . (int) $user_id . '",1)';
            $mysqli->multi_query($addnewfriend);
        }
    }
}

if ($fnt == "sendMessage") {
    $query = 'INSERT INTO message (sender,message_content,receiver,message_date) VALUES (' . (int) $usid . ',"' . $msg . '" ,' . (int) $frid . ',NOW())';
    if ($result = $mysqli->query($query)) {
        update_newestmsg($usid, $frid, $mysqli);
        echo $frid;
    }
}

else if ($fnt == "update") {
    getNumRows($frid, $usid);
}

else if ($fnt == "showMessage") {
    DisplayMessage($frid, $usid);
}

else if ($fnt == "newFriend") {
    addFriend($frid, $usid);
}

?>
