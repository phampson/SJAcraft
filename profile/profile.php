<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_GET['id'])){
  $sql = "select * from user_info where id=".$_GET['id'];
  $query = $mysqli->query($sql);
  if ($query) {
    $fetch = $query->fetch_assoc();
    $username = $fetch["username"];
    $email = $fetch["email"];
    $avatarPath = $fetch["avatar_path"];
  }
  // if GET[ID] is set, you're trying to view someone else's profile,
  // so grab their info
}
if(isset($_SESSION['user_id'])){
  $navpath = "../navbar/navbarlogged.html";

	$sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
	$query = $mysqli->query($sql);

	if (!isset($_GET['id']) and $query) {
    // if GET[ID] isn't set, view your own profile so grab your own info
    $fetch = $query->fetch_assoc();
    $username = $fetch['username'];
    $email = $fetch['email'];
    $avatarPath = $fetch['avatar_path'];
	}
}
else {
	//$navpath = "../navbar/navbarlogged.html";
    header('Location: ' . '../login/login.html');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
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


<!--background -->
<!--<div class="background">

</div>-->

<!-- profile -->
<div class="profile container col-xs-12">
   
    <div class="container uploadimg col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-1" style="margin: 0; padding: 0px">
        <div class="img container" id="profilePic">
            <img src= <?php echo $avatarPath ?> class="cover" alt="This is where your profile goes">;
        </div>
    
        <!--<?php
        echo "<div class='profilePic' id='profilePic'>
                <img src=$avatarPath alt='This is where your profile picture goes' class='container col-xs-2 col-xs-offset-1'>
             </div>"
        ?>-->

      <!-- This part lets you change profile picture, which should only display
       if $_GET["id"] isn't set, meaning you're viewing your own profile -->
        <div class="selectimg container">
             <?php if(!isset($_GET['id'])): ?>
 	        <form action="uploadProfile.php" method="post" enctype="multipart/form-data">
	            <upload><font color ="white" >Select image to upload:</upload>
	            <input type="file" name="fileToUpload" id="fileToUpload"></font>
	            <input type="submit" value="Upload Image" name="submit">
            </form>
            <?php endif; ?>
        </div>
   </div>

   <!-- Aaaand end if --> 

	<userinfo class="container col-xs-10 col-xs-offset-0 col-sm-4 col-sm-offset-1">
		<username><?php echo $username; ?></username><br>
    	<email><?php echo $email; ?></email>
        <br>
        <?php if(isset($_GET['id'])): ?>
        <?php if(isset($_SESSION['user_id'])): ?>
	    <?php
	        $query = 'select friend_id from friendlist where user_id= "'.$_SESSION['user_id'].'"';
	        $foundFriend = FALSE;
            
            if ($result = $mysqli->query($query)){
               
                while($row = $result->fetch_assoc()){
                    $friend_id = $row['friend_id'];
			        if($friend_id == $_GET['id']){
				    $foundFriend = TRUE;
			    }
		        }
	        }
	    ?>
    
        <?php if($foundFriend == FALSE): ?>
        <div class = "box">
	    <?php 
	        $addLink = "FriendFromProfile.php?id=".$_GET["id"];
   	        echo "<a class='button' href='$addLink' style=background-color: white>Add Friend</a>";
	    ?>
   	    </div>
   
        <?php endif?>
        <?php if($foundFriend == TRUE): ?>
        <div class = "box">
     		<a class="button" href="../messaging/chatroom.php" style=background-color: white>Message User</a>
        </div>
        <?php endif?>
        <?php endif; ?>
        <?php endif; ?>

		<?php
		if (isset($_GET["id"])) {
 			$addLink = "maprepo.php?id=".$_GET["id"];
		} else {
			$addLink = "maprepo.php";
        }
        ?>
   		<div class="box">	
            <a class='button' href=<?php echo $addLink ?>>Map Repo</a>
        </div>
        <br style="margin: 5px"> 
    <!-- This part is what lets you update profile info, and should only show
         if $_GET["id"] isn't set, meaning you're viewing your own profile -->
    <?php if(!isset($_GET['id'])): ?>
	
        <div class="box">
            <a class="button" href="#popup1">Edit info</a>
        </div>
        
		<div id="popup1" class="overlay container col-xs-12">
		<div class="popup container col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
			<h2>Edit Information</h2>
			<a class="close" href="#">&times;</a>
			<div class="content">
		
	            <!-- These are the forms to change user info -->	
		        <form id="form" action="change.php" method="post">
                    <input type="value" name="usrname" placeholder= "Username">
                    <br>
                    <input type="value" name="email" placeholder="Email">
                    <br>
                    <input type="password" name="password" placeholder= "Password">
                    <br>
                    <select id="digest" name ="digest">
                        <option value="-1"></option>
                        <option value="0">No email updates</option>
                        <option value="1">1 hour email updates</option>
                        <option value="2">8 hour updates</option>
                        <option value="3"> 16 hour updates</option>
                        <option value="4">daily updates</option>
                        <option value="5">weekly updates</option>
                        <option value="6">smart updates (update if unread)</option>
                    </select>
                    <br>
                    <button  id="password">Update</button>
                    <br>

		         </form>
            

        <!--    Old pop up menu form definition, saved in case the new one dies a horrible death   
                <form id="form" action="changeUserInfo.php" method="post">
	  			<input type="text" name="usrname" placeholder= "Username"><button  id="usrname">Update</button><br>
				</form>
				<form id="form" action="changeEmailInfo.php" method="post">
				<input type="text" name="email" placeholder="Email"><button  id="email">Update</button><br>
				</form>
				<form id="form" action="changePasswordInfo.php" method="post">
                    <input type="text" name="password" placeholder= "Password">
                    <button  id="password">Update</button><br>
				</form> -->
    <?php endif; ?>
			</div>
		</div>
		</div>
		
	</userinfo>

		<!--
	<button class="button addFriend" id="">Add Friend</button>
	<button class="button message" id="">Message</button>
	-->
</div>

<div class="barChart col-xs-3 col-sm-8 col-xs-offset-8">
<div class="row">
<svg width="450" height="190"></svg>
<script src="https://d3js.org/d3.v4.min.js"></script>
<!--Adapted from https://bl.ocks.org/alandunning/274bf248fd0f362d64674920e85c1eb7 
    and https://brendansudol.com/writing/responsive-d3-->

<script>
function responsivefy(svg) {
    // get container + svg aspect ratio
    var container = d3.select(svg.node().parentNode),
        width = parseInt(svg.style("width")),
        height = parseInt(svg.style("height")),
        aspect = width / height;

    // add viewBox and preserveAspectRatio properties,
    // and call resize so that svg resizes on inital page load
    svg.attr("viewBox", "0 0 " + width + " " + height)
        .attr("perserveAspectRatio", "xMinYMid")
        .call(resize);

    // to register multiple listeners for same event type, 
    // you need to add namespace, i.e., 'click.foo'
    // necessary if you call invoke this function for multiple svgs
    // api docs: https://github.com/mbostock/d3/wiki/Selections#on
    d3.select(window).on("resize." + container.attr("id"), resize);

    // get width of container and resize svg to fit it
    function resize() {
        var targetWidth = parseInt(container.style("width"));
        svg.attr("width", targetWidth);
        svg.attr("height", Math.round(targetWidth / aspect));
    }
}

var svg = d3.select("svg"),
    margin = {top: 10, right: 0, bottom: 20, left: 50},
    width = +svg.attr("width") - margin.left - margin.right,
    height = +svg.attr("height") - margin.top - margin.bottom;
  
var tooltip = d3.select("body").append("div").attr("class", "toolTip");

var x = d3.scaleBand().rangeRound([0, width]).padding(0.1),
    y = d3.scaleLinear().rangeRound([height, 0]);
  
var colours = d3.scaleOrdinal()
    .range(["orange", "green"]);

var g = svg.append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")")
    .call(responsivefy);

d3.json("data.json", function(error, data) {
    if (error) throw error;

    x.domain(data.map(function(d) { return d.area; }));
    y.domain([0, d3.max(data, function(d) { return d.value; })]);

    g.append("g")
        .attr("class", "axis axis--x")
        .attr("transform", "translate(0," + height + ")")
        .call(d3.axisBottom(x));

    g.append("g")
      	.attr("class", "axis axis--y")
      	.call(d3.axisLeft(y).ticks(5).tickFormat(function(d) { return parseInt(d); }).tickSizeInner([-width]))
      .append("text")
        .attr("transform", "rotate(-90)")
        .attr("y", 6)
        .attr("dy", "0.71em")
        .attr("text-anchor", "end")
        .attr("fill", "#5D6971");

    g.selectAll(".bar")
      	.data(data)
      .enter().append("rect")
        .attr("x", function(d) { return x(d.area); })
        .attr("y", function(d) { return y(d.value); })
        .attr("width", x.bandwidth())
        .attr("height", function(d) { return height - y(d.value); })
        .attr("fill", function(d) { return colours(d.area); })
        .on("mousemove", function(d){
            tooltip
              .style("left", d3.event.pageX - 50 + "px")
              .style("top", d3.event.pageY - 70 + "px")
              .style("display", "inline-block")
              .html((d.area) + "<br>" + (d.value));
        })
    		.on("mouseout", function(d){ tooltip.style("display", "none");});
    });
</script>
</div>
</div>




</body>
</html>
