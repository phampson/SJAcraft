<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_POST['user_id'])) {
	$userid = $_POST['user_id'];

	$query = 'select * from friendlist where interact_msgid!=newest_msgid and user_id = "'.$userid.'"';
        if ($result = $mysqli->query($query)) {
                if($result->num_rows > 0) {
                        echo 'False';
                } else {
                        echo 'True';
                }
        }
}
?>
