<?php
$frnm = $_POST["frnm"];
$usid = $_POST["usid"];
include('/home/ubuntu/ECS160WebServer/start.php');
$findnewfriendid = 'select id from user_info where username  = "'.$frnm.'"';
$trynewfriend = $mysqli->query($findnewfriendid);
if ($trynewfriend->num_rows >0){
    $ro = $trynewfriend->fetch_assoc();
    $frid = $ro['id'];
    $notfriend = 'select * from friendlist where (user_id = "'.(int)$usid.'" and friend_id = "'.$frid.'") or (user_id = "'.$frid.'" and friend_id = "'.(int)$usid.'")';
    $isfriend = $mysqli->query($notfriend);
    if($isfriend->num_rows == 0 and $usid != $frid)
    {
        $addnewfriend = 'insert into friendlist (user_id,friend_id) value ("'.(int)$usid.'","'.$frid.'");insert into friendlist (user_id,friend_id) value ("'.$frid.'","'.(int)$usid.'")';
        $mysqli->multi_query($addnewfriend);
    }
}
include('start.php');
$query = 'select friend_id from friendlist where user_id= "'.(int)$usid.'"';
if ($result = $mysqli->query($query)){
    while($row = $result->fetch_assoc()){
        $friend_id = $row['friend_id'];
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
                                    <strong>'.$friendname.'</strong>'

        echo '
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
';
}
}



?>
