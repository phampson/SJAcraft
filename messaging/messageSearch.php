<?php
$type    = $_POST["type"];
$msgSrch = $_POST["msgSrch"];
$usid    = $_POST["usid"];
include('start.php');

if ($type == 'message') {
    $query = 'select * from message where (sender= "' . $usid . '" or receiver="' . $usid . '") and message_content like "%' . $msgSrch . '%" order by message_date desc';
} 
else {
    $query = 'select * from friendlist where user_id="' . $usid . '"';
}
if ($result = $mysqli->query($query)) {
    while ($row = $result->fetch_assoc()) {
        
        if ($usid == $row['sender']) {
            $friend_id = $row['receiver'];
        } 
        else if ($usid == $row['receiver']) {
            $friend_id = $row['sender'];
        } 
        else {
            $friend_id = $row['friend_id'];
        }
        if ($type == 'message') {
            $messageContent = $row['message_content'];
        } 
        else {
            $messageContent = "";
        }
        $subMessage = $messageContent;
        if (strlen($subMessage) > 10) {
            $subMessage = substr($messageContent, 0, 10);
            $subMessage .= "...";
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                                <a href="../profile/profile.php"><img class="img-circle pull-left" style="width:45px;" style="height:45px;" src="' . $picturePath . '"></a>  
                            <button class="btn btn-link" id = ' . $friend_id . ' onclick="removeAllmessages();startNewchat(this.id, \'' . $messageContent . '\')">
                                <div class="messages">
                                    <strong>' . $friendname . '</strong>
                                </div>
                            </button>
			    ' . $subMessage . '
                        </div>
                    </div>
                </div>
';
    }
}
?>
