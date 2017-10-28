<?php
include('../login/start.php');
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
	$navpath = "../navbar/navbarlogged.html";
}
else{
	$navpath = "../navbar/navbar.html";
}

$usrnm = "";
$host= "localhost";  //database host
$username="root";  //database username for log in
$userpass="ecs160web"; //database password for log in
$databasew="web"; //database schema name
$mysqli = new mysqli($host,$username,$userpass,$databasew);	
if ($mysqli->connect_errno){
	echo "we have a problem";
}
$jeff = "jeff";
$ab = "ab";
$query = 'select * from message where (sender="'.$jeff.'" and receiver="'.$ab.'") or (sender="'.$ab.'" and receiver="'.$jeff.'")';
echo $query;		
if ($result = $mysqli->query($query)) {
	while ($row = $result->fetch_assoc()) {
		echo "hello";
	}
}
else {
	echo "error";
}
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
                    </h3>
                </div>
            </div>

        <div class="panel-body msgContainerBase1">
            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, 'chat_window_1')" value="unhide">
                                <div class="messages">
                                    <strong>$jeff | Subject: idk | <time>10:30pm</time></strong>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, 'chat_window_1')" value="unhide">
                                <div class="messages">
                                    <strong>noob666 | Subject: idk | <time>10:30pm</time></strong>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, 'chat_window_1');test();" value="unhide">
                                <div class="messages"> 
                                    <div id="username"><strong><?php echo $ab;?></strong></div>
                                </div>
				<script>
				function test() {
					console.log("hello");
				}
				</script>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, 'chat_window_1')" value="unhide">
                                <div class="messages">
                                    <strong>noob666 | Subject: idk | <time>10:30pm</time></strong>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, 'chat_window_1')" value="unhide">
                                <div class="messages">
                                    <strong>noob666 | Subject: idk | <time>10:30pm</time></strong>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div id="chatButton">
                            <div class="chatImg pull-left">
                                <a href="../profile/profile.php"><img src="../img/profpic.png"></a>  
                            </div>
                            <button class="btn btn-link" onclick="unhide(this, 'chat_window_1')" value="unhide">
                                <div class="messages">
                                    <strong>noob666 | Subject: idk | <time>10:30pm</time></strong>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Create Post Overlay -->
<div id="overlay">
</div>

<!-- Chat Window -->
<div class="container">
    <div id="chat_window_1"  class="hidden" class="topright">
    	<div class="panel panel-default">
            <div class="panel-heading topBar">
                <div>
                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Conversation with noob666 - Subject: idk
                    <img class="close pull-right" src="../img/close.png" onclick ="hide(this, 'chat_window_1')" value="hide"></h3>
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
		$ab = "ab";
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
