<?php
$frid    = $_POST["frid"];
$usid    = $_POST["usid"];
$msgSrch = $_POST["msg"];
include('/home/ubuntu/ECS160WebServer/start.php');
echo $msgSrch;

function DisplayMessage($friend_id, $user_id, $msgSrch)
{
    global $mysqli;
    $query = 'select * from message where ((sender= "' . $user_id . '" and receiver = "' . $friend_id . '") or (sender="' . $friend_id . '" and receiver="' . $user_id . '")) and message_content like "%' . $msgSrch . '%" order by message_date desc';
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $content  = $row['message_content'];
            $msgid    = $row['message_id'];
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
                        <div id='$msgid' class='messages msg_sent'>
                            <p style='word-wrap:break-word'><a href='history.php?frid=$friend_id&mid=$msgid'>$content</a></p>
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
                        <div id='$msgid' class='messages msg_receive'>
                            <p style='word-wrap:break-word'><a href='history.php?frid=$friend_id&mid=$msgid'>$content</a></p>
                            <time>$friendname | $date</time>
                        </div>
                    </div>
                </div>";
            }
        }
    }
    
}
DisplayMessage($frid, $usid, $msgSrch);
?>
