<?php

include('../login/start.php');

error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
	echo $_SESSION['user_id'];
	$sql = 'select * from user_info where username="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);
	if($query) {
		$fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$email = $fetch['email'];
		$avatarPath = $fetch['avatar_path'];
		echo $email;
		$navpath = "../navbar/navbarlogged.html";
	}
}
else{
	echo"nothing";
	$username = "username unknown";
	$email = "email unknown";
	$navpath = "../navbar/navbar.html";
	echo "\n" . $navpath;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II-Forum</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<link rel="stylesheet" href="stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<!-- Search bar-->
<div id="searchBar">
  <h1><font color="white"><center> Forums </center></font></h1>
  <div class="container" id="hdrContainer">
    <nav class="navbar navbar-inverse">
      <form class="navbar-form navbar-left">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search Threads/Users">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit">
                  <i class="glyphicon glyphicon-search"></i>
                </button>
              </div>
          </div>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li>
        	<div id="myProfButton">
	        	<button id="myProfButton" class="btn btn-link"> 
	        		<span class="glyphicon glyphicon-user"></span> My Profile
	        	</button>
	        </div>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
        	<div id="discussionButton">
	        	<button class="btn btn-link" onclick="on()">
	        		<span class="glyphicon glyphicon-plus"></span> Start New Discussion
	        	</button>
	        </div>
        </li>
      </ul>
    </nav>
  </div>
</div>

<!-- Tab Container -->
<div id="tabContainer" class="container">

  <div id="tab" class="tab">
    <button class="tablinks" onclick="openCategory(event, 'Beginners')">Beginners</button>
    <button class="tablinks" onclick="openCategory(event, 'Strategies')">Strategies</button>
    <button class="tablinks" onclick="openCategory(event, 'Maps')">Maps</button>
    <button class="tablinks" onclick="openCategory(event, 'Game_Updates')">Game Updates</button>
    <button class="tablinks" onclick="openCategory(event, 'General')">General</button>
  </div>


  <div id="Beginners" class="tabcontent">
    <h3>Beginners</h3>
    <p>
        <div class="container">
          <a href="#">
            <div class="jumbotron">
              <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Alice</p></div>
              <h3> How do I move around?</h3>
              <p> I don't even know how to move in this game? It's not the arrow keys. It's not asdw. How?? I swear I clicked every button on my keyboard and my character still won't move. I really want to play this game because it looks like so much fun when other people play it but I can't because I don't know how to move. Edit: Jk I know how to move. You click your person aand then click on where you want to go and your character will go there. </p>

              <footer> 
              10/17/17

              </align</footer>
            </div>
          </a>
        </div>

        <div class="container">
          <a href="#">
            <div class="jumbotron">
              <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
              <h3> How do I win?</h3>
              <p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
            </div>
          </a>
        </div>

        <div class="container">
          <a href="#">
            <div class="jumbotron">
              <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
              <h3> How do I win?</h3>
              <p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
            </div>
            </a>
        </div>
        <div class="container">
          <a href="#">
            <div class="jumbotron">
              <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
              <h3> How do I win?</h3>
              <p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
            </div>
          </a>
        </div>

    </p>
  </div>

  <div id="Strategies" class="tabcontent">
    <h3>Strategies</h3>
    <p>Paris is the capital of France.</p> 
  </div>

  <div id="Maps" class="tabcontent">
    <h3>Maps</h3>
    <p>Tokyo is the capital of Japan.</p>
  </div>

  <div id="Game_Updates" class="tabcontent">
    <h3>Game Updates</h3>
    <p>Tokyo is the capital of Japan.</p>
  </div>

  <div id="General" class="tabcontent">
    <h3>General</h3>
    <p>Tokyo is the capital of Japan.</p>
  </div>
  
<!-- Create Post Overlay -->
<div id="overlay">
</div>

<!-- Create Post Container  -->
<div class="container" id="postContainer">
	<form action="#" method="post">

		<img id="close" src="../img/close.png" onclick ="off()">
		<h1>Create a New Post</h1>
		<hr></hr>

		<div class="profInfo">
			<img alt="defaultProfPic" src="../img/profpic.png" style="width:100px;height:100px;">
			<h3>username</h3>
		</div>

		<div class="postInfo">
			<label>Select Post Category: </label>
			<select name="category">
				<option value="" disabled selected>Select One</option>
			    <option value="beginner">Beginner</option>
			    <option value="maps">Maps</option>
			    <option value="general">General</option>
  			</select>
  			<br>
			<label>Post Name: </label>
			<input type="text" id="postName" name="" placeholder="Enter Post Name"><br><br>
			<label> Message: </label><br>
			<textarea id="postMsg" name="" placeholder="Message"></textarea>
			<button class="btn-link" onclick="" id="submit">Send</button>
		</div>

	</form>

</div>

</body>

<script type="text/javascript" src="forum.js">
</script>

</html>
