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
function phpConsole($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    
    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php

if (isset($_SESSION['user_id'])) {
    $sql     = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query   = $mysqli->query($sql);
    $navpath = "../navbar/navbarlogged.html";
    if ($query) {
        $fetch    = $query->fetch_assoc();
        $username = $fetch['username'];
        $email    = $fetch['email'];
    }
}

else {
    $navpath = "../navbar/navbar.html";
}
?>

<script>
    function visitProfile(){
        window.location='../profile/profile.php';
    }
</script>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II-Forum</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<link rel="stylesheet" href="stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

</script>
</head>

<body onload="dumpAllPosts();">

<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<!-- Search bar-->
<div id="searchBar">
  <h1><center> Forums </center></font></h1>
	<div class="container col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
		<hr>
	</div>
	<br>
  <div class="container" id="hdrContainer">
    <nav class="navbar navbar-inverse">

    <!-- Commented for now. Delete later.      
    <form class="navbar-form navbar-left" action="search.php" method="post"> -->
    <form class="navbar-form navbar-left">    
        <div class="input-group">
            <input type="text" name="searchText" class="form-control btn-sm" placeholder="Search Threads/Users">
              <div class="input-group-btn">
                <input class="btn-sm btn-simple" type="button" name="submitButton" value="SEARCH" onClick="search(this.form);">
                <!-- <button class="btn btn-default" type="submit"> -->
                  <i class="glyphicon glyphicon-search"></i>
                </button>
              </div>
          </div>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li>
        	<div id="myProfButton">
	        	<button id="myProfButton" class="btn btn-link" onclick = "visitProfile();"> 
	        		<h4 style="margin-top: 0px;"><span class="glyphicon glyphicon-user"></span> My Profile</h4>
	        	</button>
	        </div>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
        	<div id="discussionButton">
	        	<button class="btn btn-link" onclick="on()">
	        		<h4 style="margin-top: 0px"><span class="glyphicon glyphicon-plus"></span> Start New Discussion</h4>
	        	</button>
	        </div>
        </li>
      </ul>
    </nav>
  </div>
</div>

<!-- For search results only -->
<div id="searchResults">

</div>

<!-- Tab Container -->
<div id="tabContainer" class="container">

	<div id="tab" class="tab div1">
		<button class="tablinks" onclick="openCategory(event, 'Beginners')"><h3>Beginners</h3></button>
		<button class="tablinks" onclick="openCategory(event, 'Strategies')"><h3>Strategies</h3></button>
		<button class="tablinks" onclick="openCategory(event, 'Maps')"><h3>Maps</h3></button>
		<button class="tablinks" onclick="openCategory(event, 'Game_Updates')"><h3>Game Updates</h3></button>
		<button class="tablinks" onclick="openCategory(event, 'General')"><h3>General</h3></button>
	</div>


	<div id="Beginners" class="tabcontent div1" style="height: 100%">
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


	<div id="Strategies" class="tabcontent div1" style="height: 100%">
    		<p>
			
		</p> 
	</div>

  	<div id="Maps" class="tabcontent div1" style="height: 100%">
    		<p>
    		</p>
  		</div>

  	<div id="Game_Updates" class="tabcontent div1" style="height: 100%">
    		<p>

    		</p>
  	</div>

  	<div id="General" class="tabcontent div1" style="height: 100%">
    		<p>
			

    		</p>
  	</div>
</div>
  
<!-- Create Post Overlay -->
<div id="overlay">
</div>

<!-- Create Post Container  -->
<div class="container-fluid col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1" id="postContainer">
<div class="panel panel-default">
	<div class="panel-heading">
		<div class="panel-title">
			<span class="glyphicon glyphicon-remove" onclick="off()" style="float: right;"></span>
			<h3 style="color: black;">Create a New Post</h3>
		</div>
	</div>
	<div class="panel-body">
		<div class="profInfo container col-xs-12 col-xs-offset-0 col-sm-12 col-sm-offset-0">
			<center><img alt="defaultProfPic" src="../img/profpic.png" style="width:100px;height:100px;"></center>
                        <h3 style="color: black;">Username</h3>
		</div>
		<form action="post.php" method="post">
			<div class="postInfo">
				<label><h2 style="color: black;">Select Post Category: </h2></label>
                                <br>
				<select name="category">
					<option value="" disabled selected>Select One</option>
				    	<option value="beginner">Beginner</option>
				    	<option value="strategies">Strategies</option>
			    		<option value="maps">Maps</option>
			    		<option value="gameUpdates">Game Updates</option>
			   	 	<option value="general">General</option>
  				</select>
  				<br><br>
				<label><h2 style="color: black;">Post Name: </h2></label>
					<input type="text" id="postName" name="postName" placeholder="Enter Post Name"><br><br>
				<label><h2 style="color: black;">Message: </h2></label><br>
				<textarea id="postMsg" name="message" placeholder="Message"></textarea>
                        	<input type="file" name="fileToUpload" id="fileToUpload">
                        	<input type="button" class="btn-simple" id="upJQuery" value="upload"><br>
				<button class="btn-simple" onclick="" id="submit">Submit</button>
		</div>
	</div>
	</form>
</div>
</div>

</body>

<script type="text/javascript" src="forum.js">
</script>
<script>
$('#upJQuery').on('click', function() {
 var fd = new FormData();
 fd.append("upload", 1);
 fd.append("fileToUpload", $("#fileToUpload").get(0).files[0]);
 $.ajax({
 url: "Forumattachment.php",
 type: "POST",
 processData: false,
 contentType: false,
 data: fd,
 success: function(d) {
 if (d.indexOf("Error") <0){
 $("#fileToUpload").val("");
 document.getElementById("postMsg").value +="\n"+d+"\n";
 }
 else {alert("Cannot Upload");}
 }
 });
});
</script>

</html>
