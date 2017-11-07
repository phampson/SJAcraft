<?php

/*
 * TO DO
 * 1. Add functionality to make sure that in order to create a new post, user SHOULD provide ALL details, i.e.
 *      1. Post Category.
 *      2. Post Name.
 *      3. Message.
 * 2. Only logged in users should be able to create a new post.
 */

// Imports & Error Reporting
include('/home/ubuntu/ECS160WebServer/start.php');

// Helper function
function phpConsole($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php

if(isset($_SESSION['user_id'])) {
	$sql = 'select * from user_info where username="' . $_SESSION['user_id'] . '"';
    	$query = $mysqli->query($sql);
	$navpath = "../navbar/navbarlogged.html";
	if($query) {
		$fetch = $query->fetch_assoc();
		$username = $fetch['username'];
		$email = $fetch['email'];
	}
}

else{
	$navpath = "../navbar/navbar.html";
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
      <form class="navbar-form navbar-left" action="search.php" method="post">
        <div class="input-group">
            <input type="text" name="searchText" class="form-control" placeholder="Search Threads/Users">
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
		<p>
		
			<!-- 
			<a href="#">
				<div class="jumbotron">
					<div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Alice</p></div>
					<h3> How do I move around?</h3>
					<p> I don't even know how to move in this game? It's not the arrow keys. It's not asdw. How?? I swear I clicked every button on my keyboard and my character still won't move. I really want to play this game because it looks like so much fun when other people play it but I can't because I don't know how to move. Edit: Jk I know how to move. You click your person aand then click on where you want to go and your character will go there. </p>
					<footer> 10/17/17 </footer>
				</div>
			</a>
			-->

    		</p>
	</div>


	<div id="Strategies" class="tabcontent">
    		<p>
			<!--
			<a href="#">
		    		<div class="jumbotron">
		      			<div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Alice</p></div>
					<h3> How do I move around?</h3>
					<p> I don't even know how to move in this game? It's not the arrow keys. It's not asdw. How?? I swear I clicked every button on my keyboard and my character still won't move. I really want to play this game because it looks like so much fun when other people play it but I can't because I don't know how to move. Edit: Jk I know how to move. You click your person aand then click on where you want to go and your character will go there. </p>
					<footer> 10/17/17 </footer>
		    		</div>
		  	</a>

		  	<a href="#">
		    		<div class="jumbotron">
		      			<div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
		    			<h3> How do I win?</h3>
		      			<p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
		    		</div>
		  	</a>
			-->
		</p> 
	</div>

  	<div id="Maps" class="tabcontent">
    		<p>
			<!--
          		<a href="#">
            			<div class="jumbotron">
              				<div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Alice</p></div>
              				<h3> How do I move around?</h3>
              				<p> I don't even know how to move in this game? It's not the arrow keys. It's not asdw. How?? I swear I clicked every button on my keyboard and my character still won't move. I really want to play this game because it looks like so much fun when other people play it but I can't because I don't know how to move. Edit: Jk I know how to move. You click your person aand then click on where you want to go and your character will go there. </p>
					<footer> 10/17/17 </footer>
            			</div>
          		</a>

          		<a href="#">
            			<div class="jumbotron">
				      <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
				      <h3> How do I win?</h3>
				      <p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
            			</div>
          		</a>
			-->
    		</p>
  		</div>

  	<div id="Game_Updates" class="tabcontent">
    		<p>
			<!--
			<a href="#">
				<div class="jumbotron">
				     	<div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Alice</p></div>
				      	<h3> How do I move around?</h3>
				      	<p> I don't even know how to move in this game? It's not the arrow keys. It's not asdw. How?? I swear I clicked every button on my keyboard and my character still won't move. I really want to play this game because it looks like so much fun when other people play it but I can't because I don't know how to move. Edit: Jk I know how to move. You click your person aand then click on where you want to go and your character will go there. </p>

				      	<footer> 10/17/17 </footer>
			    	</div>
			</a>

			<a href="#">
				<div class="jumbotron">
					<div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
				      	<h3> How do I win?</h3>
				      	<p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
			    	</div>
			 </a>
			-->
    		</p>
  	</div>

  	<div id="General" class="tabcontent">
    		<p>
			<!--
			<a href="#">
			    <div class="jumbotron">
			      <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Alice</p></div>
			      <h3> How do I move around?</h3>
			      <p> I don't even know how to move in this game? It's not the arrow keys. It's not asdw. How?? I swear I clicked every button on my keyboard and my character still won't move. I really want to play this game because it looks like so much fun when other people play it but I can't because I don't know how to move. Edit: Jk I know how to move. You click your person aand then click on where you want to go and your character will go there. </p>

			      <footer> 10/17/17 </footer>
			    </div>
			  </a>


			  <a href="#">
			    <div class="jumbotron">
			      <div class="col-sm-2"> <img align=left src="../img/default.png" alt="Warcraft main picture" style="width:100px;height:100px;"> <p>Kelly</p></div>
			      <h3> How do I win?</h3>
			      <p> So yeah, how exactly do I win at warcraft? Do I collect resouces or build buildings?</p>
			    </div>
			  </a>
			-->

    		</p>
  	</div>
</div>
  
<!-- Create Post Overlay -->
<div id="overlay">
</div>

<!-- Create Post Container  -->
<div class="container" id="postContainer">
	<form action="post.php" method="post">

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
			    <option value="strategies">Strategies</option>
			    <option value="maps">Maps</option>
			    <option value="gameUpdates">Game Updates</option>
			    <option value="general">General</option>
  			</select>
  			<br>
			<label>Post Name: </label>
			<input type="text" id="postName" name="postName" placeholder="Enter Post Name"><br><br>
			<label> Message: </label><br>
			<textarea id="postMsg" name="message" placeholder="Message"></textarea>
			<button class="btn-link" onclick="" id="submit">Send</button>
		</div>
	</form>
</div>

</body>

<script type="text/javascript" src="forum.js">
</script>

</html>
