<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_SESSION['user_id'])){
	$navpath = "../navbar/navbarlogged.html";
}
else{
	$navpath = "../navbar/navbar.html";
}

$usrnm = "";

$jeff = "jeff";
$ab = "ab";
$query = 'select * from message where (sender="'.$jeff.'" and receiver="'.$ab.'") or (sender="'.$ab.'" and receiver="'.$jeff.'")';
$id = $_SESSION['user_id'];
		$friend_query = 'select * from friendlist where user_id="'.$id.'"';
		
		if ($result = $mysqli->query($friend_query)) {
		    while ($row = $result->fetch_assoc()) {
			$friend_id = $row['friend_id'];
			echo $friend_id; 			    
			$message_query = 'select* from user_info where id= "'.$friend_id.'"';
			if ($query = $mysqli->query($message_query)) {
				echo "NO";
}
else {
	echo "error";
}}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Warcraft II</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="../stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="messaging.js"></script>
</head>

<body>

<!-- Nav Bar -->
<div id="navbar"></div>
<?php
echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<!-- Inbox Side-Panel --> 
<div class="container">       
    <div id="inbox" class="topleft">
        <div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-message-in">
                        </span> Inbox <span class="badge">0 new</span>
                        <button class="btn btn-default pull-right" onclick="unhide(this, 'messageForm')" value="unhide"><span class="glyphicon glyphicon-plus"></span> New Message</button>
                    </h3>
                </div>
            </div>

        <div class="panel-body msgContainerBase1">
            <div class="panel-group">
		<?php
		$host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli = new mysqli($host,$username,$userpass,$databasew);
		
		if ($mysqli->connect_errno){
		    echo "we have a problem";
		}
		$id = $_SESSION['user_id'];
		$friend_query = 'select * from friendlist where user_id="'.$id.'"';
		
		if ($result = $mysqli->query($friend_query)) {
		    while ($row = $result->fetch_assoc()) {
			$friend_id = $row['friend_id']; 			    
			$message_query = 'select* from user_info where id= "'.$friend_id.'"';
			if ($query = $mysqli->query($message_query)) {
				$fetch = $query->fetch_assoc();
				$friend_name = $fetch['username'];
				echo '
		<div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, \'chat_window_'.$friend_id.'\');test();" value="unhide">
                                <div class="messages"> 
                                    <div id="username"><strong>'.$friend_name.'</strong></div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>';
			}   
		    }
		}
		?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Create Post Overlay -->
<div id="overlay">
</div>

<!-- New Message Form -->
<div class="container">
    <div id="messageForm" class="hidden">
        <div class="panel panel-default">
            <div class="panel-heading topBar">
                <h3 class="panel-title">Compose New Message</h3>
            </div>

            <div class="panel-body msgContainerBase2">
                 <div class="form-group">
                    <label for="username">To:</label>
                    <input type="username" class="form-control" id="username" placeholder="Search Friends...">
                    <button type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-search"></span></button>
                  </div>
                  <div class="form-group">
                    <label for="sbj">Subject: </label>
                    <input type="sbj" class="form-control" id="sbj" placeholder="Enter Subject...">
                  </div>
                  <div class="form-group">
                    <label for="msg">Message:</label>
                    <textarea type="msg" class="form-control" id="msg" rows="6" placeholder="Write Your Message Here..."></textarea>
                    <button type="button" class="btn btn-primary pull-right">Send</button>
                  </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Window -->
<?php
$id2 = $_SESSION['user_id'];
		$friend_query2 = 'select * from friendlist where user_id="'.$id.'"';
		
		if ($res2 = $mysqli->query($friend_query2)) {
		    while ($row2 = $res2->fetch_assoc()) {
			$friend_id2 = $row2['friend_id']; 			    
			$message_query2 = 'select* from user_info where id= "'.$friend_id2.'"';
			if ($query2 = $mysqli->query($message_query2)) {
				$fetch2 = $query2->fetch_assoc();
				$friend_name2 = $fetch2['username'];
				echo'
<div class="container">
    <div id="chat_window_'.$friend_id2.'"  class="hidden" class="topright">
    	<div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Conversation with '.$friend_name2.'
                    <img class="close pull-right" src="../img/close.png" onclick ="hide(this, \'chat_window_'.$friend_id2.'\')" value="hide"></h3>
                </div>
            </div>

            <div class="panel-body msgContainerBase2">
	';
		$host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli = new mysqli($host,$username,$userpass,$databasew);
		
		if ($mysqli->connect_errno){
		    echo "we have a problem";
		}
		$jeff = "jeff";
		$query = 'select * from message where (sender="'.$jeff.'" and receiver="'.$friend_name2.'") or (sender="'.$friend_name2.'" and receiver="'.$jeff.'")';
		
		if ($result = $mysqli->query($query)) {
		    while ($row = $result->fetch_assoc()) {
			    $receiver = $row['receiver'];
			    $message_content = $row['message_content'];
			    $date = $row['message_date'];
			    
			    if ($receiver != $jeff) {
			    	echo "
		<div class='row msgContainer base_sent'>
                    <div class='col-md-10 col-xs-10'>
                        <div class='messages msg_sent'>
                            <p>$message_content</p>
                            <time>$jeff | $date</time>
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
                            <p>$message_content</p>
                            <time>$friend_name2 | $date</time>
                        </div>
                    </div>
                </div>";
			    }
		    }
		}
		
echo '
            </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                    </span>
                </div>
            </div>
		</div>
    </div>';
}}}
?>
<div class="container">
    <div id="chat_window_64"  class="hidden" class="topright">
    	<div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Conversation with pranav
                    <img class="close pull-right" src="../img/close.png" onclick ="hide(this, 'chat_window_64')" value="hide"></h3>
                </div>
            </div>

            <div class="panel-body msgContainerBase2">
		<?php
		$host= "localhost";  //database host
		$username="root";  //database username for log in
		$userpass="ecs160web"; //database password for log in
		$databasew="web"; //database schema name
		$mysqli = new mysqli($host,$username,$userpass,$databasew);
		
		if ($mysqli->connect_errno){
		    echo "we have a problem";
		}
		$jeff = "jeff";
		$ab = "pranav";
		$query = 'select * from message where (sender="'.$jeff.'" and receiver="'.$ab.'") or (sender="'.$ab.'" and receiver="'.$jeff.'")';
		
		if ($result = $mysqli->query($query)) {
		    while ($row = $result->fetch_assoc()) {
			    $receiver = $row['receiver'];
			    $senrec	= "";//class for if message was sent or received.
			    $msgContainer = "";//class for the msg buble
			    if ($sender = 'jeff') {
				    $senrec = "messages msg_sent";
				    $msgContainer = "row msgContainer base_sent";
			    }
			    else {
				    $senrec = "messages msg_receive";	
				    $msgContainer = "row msgContainer base_receive";		
			    }
			    $message_content = $row['message_content'];
			    $date = $row['message_date'];
			    
			    if ($receiver == $jeff) {
			    	echo "
		<div class='row msgContainer base_sent'>
                    <div class='col-md-10 col-xs-10'>
                        <div class='messages msg_sent'>
                            <p>$message_content</p>
                            <time>jeff | $date</time>
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
                            <p>$message_content</p>
                            <time>ab | $date</time>
                        </div>
                    </div>
                </div>";
			    }
		    }
		}
		?>

            </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                    </span>
                </div>
            </div>
		</div>
    </div>
</div>
</body>
</html>
