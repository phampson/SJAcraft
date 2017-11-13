function ShowFriends($userid,$mysqli) {
    $query = 'select * from friendlist where interact_msgid!=newest_msgid and user_id = "'.$userid.'"';
    if ($result = $mysqli->query($query)){
        if($result->num_rows > 0){
            echo 'False';            
	} else {
            echo 'True';
        }
    }
}
