<?php
$frid = $_POST["frid"];
$usid = $_POST["usid"];
include('/home/ubuntu/ECS160WebServer/start.php');

function DisplayMessage($friend_id, $user_id)
{
    global $mysqli;
    $query = 'SELECT * FROM message WHERE (sender = "'.(int)$user_id.'" AND receiver = '.$friend_id.') OR (sender = '.$friend_id.' AND receiver = "'.(int)$user_id.'")';
    if ($result = $mysqli->query($query)){
        while($row = $result->fetch_assoc()){
	    $content = $row['message_content'];
            $receiver = $row['receiver'];
            $date = $row['message_date'];
            $sql = 'SELECT username FROM user_info WHERE id = "'.(int)$user_id.'"';
            $qry = $mysqli->query($sql);
            $myrow = $qry -> fetch_assoc();
            $myname = $myrow['username'];
            $sql = 'SELECT username FROM user_info WHERE id = "'.(int)$friend_id.'"';
            $qry = $mysqli->query($sql);
            $friendrow = $qry -> fetch_assoc();
            $friendname = $friendrow['username'];
            if ($receiver == $friend_id) {
	        echo "
		<div class='row msgContainer base_sent'>
                    <div class='col-md-10 col-xs-10'>
                        <div class='messages msg_sent'>
                            <p>$content</p>
                            <time>$myname | $date</time>
                        </div>
                    </div>
                    <div class='col-md-2 col-xs-2 avatar'>
                        <img src='../img/profpic.png' class=' img-responsive '>
                    </div>
                </div>
				";
	    }
	    else {
	        echo "
		<div class='row msgContainer base_receive'>
                    <div class='col-md-2 col-xs-2 avatar'>
                        <img src='../img/profpic.png' class=' img-responsive '>
                    </div>
                    <div class='col-xs-10 col-md-10'>
                        <div class='messages msg_receive'>
                            <p>$content</p>
                            <time>$friendname | $date</time>
                        </div>
                    </div>
                </div>";
	    }
	}
    }

}

DisplayMessage($frid,$usid);


?>
