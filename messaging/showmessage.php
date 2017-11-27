<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
include('/home/ubuntu/ECS160WebServer/start.php');

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
                if (preg_match("/^attachment_files\/.*/", $content, $matches)) {
                    echo "
                         <p><a href='$content'>$content</a></p>";
                } 
                else {
                    echo "<p>$content</p>";
                }
                echo "
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
                if (preg_match("/^attachment_files\/.*/", $content, $matches)) {
                    echo "
                         <p><a href='$content'>$content</a></p>";
                } 
                else {
                    echo "<p>$content</p>";
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

DisplayMessage($frid, $usid);
/***
if (preg_match("/php/i", "PHP is the web scripting language of choice.", $matches))
{
echo "A match was found:" . $matches[0];
}
else
{
echo "<p>$content</p>";
}
***/
?>
