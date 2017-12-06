
<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_GET['badUpload'])) {
   switch ($_GET['badUpload']) {
       case "1":
           echo '
           <script>
               alert("Upload error: Invalid extension.");
           </script>';
           break;
       case "2":
           echo '
           <script>
               alert("Upload error: Filesize too large.");
           </script>';
           break;
       case "3":
           echo '
           <script>
               alert("Upload error: File already exists. Try renaming.");
           </script>';
           break;
       default:
           echo '
           <script>
               alert("Upload error: Something went wrong!");
           </script>';
   }
}

if (isset($_GET['id'])) {
    $sql   = "select * from user_info where id=" . $_GET['id'];
    $query = $mysqli->query($sql);
    if ($query) {
        $fetch      = $query->fetch_assoc();
        $username   = $fetch["username"];
        $email      = $fetch["email"];
        $avatarPath = $fetch["avatar_path"];
    }
    // if GET[ID] is set, you're trying to view someone else's profile,
    // so grab their info
}

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
    
    $sql   = 'select * from user_info where id="' . $_SESSION['user_id'] . '"';
    $query = $mysqli->query($sql);
    
    if (!isset($_GET['id']) and $query) {
        // if GET[ID] isn't set, view your own profile so grab your own info
        $fetch      = $query->fetch_assoc();
        $username   = $fetch['username'];
        $email      = $fetch['email'];
        $avatarPath = $fetch['avatar_path'];
    }
} 
else {
    //$navpath = "../navbar/navbarlogged.html";
    //echo "no session";
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
	<script src='barChart.js'></script>
	<script src='https://d3js.org/d3.v4.min.js'></script>
	<script src='https://d3js.org/d3-selection-multi.v0.4.min.js'></script>
	<script src='https://npmcdn.com/babel-core@5.8.34/browser.min.js'></script>
</head>
<body>
<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>



<!-- profile -->

<div class="div1 container col-sm-10 col-sm-offset-1" id="border-gold">
   
    <!--profile picture-->
    <div class="container uploading col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-1" style="margin: 0; padding: 0px">
        <div class="img container" id="profilePic">
            <img src= <?php echo $avatarPath ?> class="cover" alt="Profile pic" style="width:200px; height: 200px;">
        </div>
    
       
        <!-- This part lets you change profile picture, which should only display
        if $_GET["id"] isn't set, meaning you're viewing your own profile -->
        <div class="selecting container">
            <?php if(!isset($_GET['id'])): ?>

 	        <form action="uploadProfile.php" method="post" enctype="multipart/form-data">
	            <upload><p>Select image to upload:</upload>
	            <input type="file" name="fileToUpload" id="fileToUpload"><p>
	            <input type="submit" class="btn-simple" value="Upload Image" name="submit">
            </form>
            <?php
endif;
?>
        </div>
    </div>

    <!-- user info and buttons --> 
	<div class="container col-xs-10 col-xs-offset-0 col-sm-4 col-sm-offset-1">
		<h2><?php echo $username; ?></h2>
    	<h3><?php echo $email; ?></h3>
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
    
            <?php 
		if($foundFriend == FALSE):
	        	$addLink = "FriendFromProfile.php?id=".$_GET["id"]; ?>
       	        	<a href= <?php echo $addLink?> ><input type="submit" class="btn-simple" value="Add Friend" name="submit"> </a>
	  	<?php endif;?>

            <?php if($foundFriend == TRUE): ?>
         		<a class="btn-simple" href="../messaging/history.php?frid=<?php echo $friend_id ?>"><input type="submit" class="btn-simple"value="Message User" name="submit"></a>

            <?php endif;?>
        <?php endif; ?>
        <?php endif; ?>
        <br> 

		<?php
		if (isset($_GET["id"])) {
 			$mapRepo = "maprepo.php?id=".$_GET["id"];
      $packageRepo = "packagerepo.php?id=".$_GET["id"];
		} else {
			$mapRepo = "maprepo.php";
      $packageRepo = "packagerepo.php";
    }
    ?> 	
        <a class='btn-simple' href=<?php echo $mapRepo ?>><input type="submit" class="btn-simple"value="Map Repo" name="submit"></a>

  <br>

        <a class='btn-simple' href=<?php echo $packageRepo ?>><input type="submit" class="btn-simple"value="Package Repo" name="submit"></a>	
  <br>

        <!-- This part is what lets you update profile info, and should only show
         if $_GET["id"] isn't set, meaning you're viewing your own profile -->

        <?php if(!isset($_GET['id'])): ?>

	
            <a class="btn-simple" href="#popup1"><input type="submit" class="btn-simple"value="Edit Info" name="submit"></a>
        
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
                        </select>
                        <br>
                        <select id="smart" name ="smart">
                            <option value="-1"></option>
                            <option value="0">No smart digest</option>
                            <option value="1">Smart digest</option>
                        </select>
                        <br>
                        <button class="btn-simple" id="password">Update</button>
                        <br>
		             </form>
              
              
			    </div>
		    </div>
		    </div>
         <?php endif; ?>
         
         <?php if(!isset($_GET['id'])): ?>
		<br>
            <a class="btn-simple" href="#popup2"><input type="submit" class="btn-simple"value="Refer A Friend" name="submit"></a>
        
		    <div id="popup2" class="overlay container col-xs-12">
		    <div class="popup container col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-4">
			    <h2>Refer A Friend</h2>
			    <a class="close" href="#">&times;</a>
			    <div class="content">
		
	                <!-- These are the forms to change refer friend -->	
		            <form id="form" action="referfriend.php" method="post">
                        <input type="value" name="friendemail" placeholder= "email">
                        <br>
                        <button class="btn-simple" id="referfriend">Refer</button>
                        <br>
		             </form>
              
              
			    </div>
		    </div>
		    </div>
         <?php endif; ?>	
    
	</div>


    <!-- graph -->
   
<!--
        <svg class="container" id="barChart">
        <div class="container col-xs-3">

        <!--Bar Chart adapted from https://bl.ocks.org/jfsiii/55f1c89944cd96718bdccc8260aeea4e

        <script>
        const maxWidth = 340;
        const maxHeight = 200;
          const margin = {
            top: 80,
            right: 0,
            bottom: 0,
            left: 40
          };

          const xVariable = 'winloss';
          const yVariable = 'frequency';

          let xScale;
          let yScale;
          let xAxis;
          let yAxis;

          d3.select('body')
            .styles({
              margin: 0,
              position: 'fixed',
              top: 0,
              right: 0,
              bottom: 0,
              left: 0
            })

          const svg = d3.select('#barChart')
            .attr('width', '100%')
            .attr('height', '100%');

          const chartArea = svg.append('g')
            .classed('chartArea', true)
            .attr('transform', `translate(${margin.left}, ${margin.top})`)

          const barGroup = chartArea.append('g')
            .classed('bars', true);

          const xAxisG = chartArea.append('g')
            .classed('axis', true)
            .classed('x', true);

          const yAxisG = chartArea.append('g')
            .classed('axis', true)
            .classed('y', true);
          
          var toolTip = svg.append('div').attr('class', 'toolTip');

          function type(d) {
            // coerce to a Number from a String (or anything)
            d[yVariable] = Number(d[yVariable]);
            return d;
          }

          d3.csv('data.csv', type, (error, data) => {
            console.log('data', data);

            function initChart() {
              const width = 200;
              const height = 100;
            

              // Initialise scales
              xScale = d3.scaleBand()
                .domain(data.map(d => d[xVariable]));

              yScale = d3.scaleLinear()
                .domain([0, d3.max(data.map(d => d[yVariable]))]);
              console.log(yScale);

              // Build the x-axis
              xAxis = d3.axisBottom()
                .scale(xScale);

              // Build the y-axis
              yAxis = d3.axisLeft()
                .scale(yScale);
            }

            function updateScales() {
              const newWidth = d3.min([W.getViewportWidth(), maxWidth]) - margin.left - margin.right;
              const newHeight = d3.min([W.getViewportHeight(), maxHeight]) - margin.top - margin.bottom;

              xScale
                .range([0, newWidth])
                .paddingInner(0.1)
                .bandwidth(10);

              yScale.range([newHeight, 0]);
            }

            function updateAxes(firstCall) {
              const newHeight = d3.min([W.getViewportHeight(), maxHeight]);

              // position the xAxisG before the transition the first time
              if (typeof firstCall !== 'undefined') {
                xAxisG
                  .attr('transform', `translate(0, ${newHeight - margin.top - margin.bottom})`);
              }

                xAxisG
                  .transition()
                  .duration(150)
                  .attr('transform', `translate(0, ${newHeight - margin.top - margin.bottom})`)
                  .call(xAxis);

              yAxisG
                .transition()
                  .duration(150)
                  .call(yAxis);

              // style the axes
              d3.selectAll('.axis text')
                .styles({
                  'font-family': 'sans-serif',
                  'font-size': '14px'
                })

              d3.selectAll('.axis path')
                .styles({
                  fill: 'none',
                  stroke: '#161616'
                })

              d3.selectAll('.axis line')
                .style('stroke', 'black');
            }

            function updateBars() {
              const updateSelection = barGroup.selectAll('rect')
                .data(data);

              const enterSelection = updateSelection.enter()
                .append('rect')
                  .classed('rect', true)
                  .style('fill', 'gray')
            .style('fill-opacity', '0.7');

              updateSelection.exit()
                .remove();

              enterSelection
                .merge(updateSelection)
                .transition()
                  .duration(150)
                  .attr('x', function(d) {return xScale(d[xVariable]);})
                  .attr('width', xScale.bandwidth)
                  .attr('y', d => yScale(d[yVariable]))
                  .attr('height', d => yScale(0) - yScale(d[yVariable]));

              enterSelection
                .on('mouseover', function () {
                  d3.select(this)
                    .styles({
                      'fill': 'navy',
                      'fill-opacity': 0.6
                    });
                })
          .on('mousemove', function() {
              toolTip
                .style("left", d3.event.pageX - 50 + "px")
                .style("top", d3.event.pageY - 70 + "px")
                .style("display","inline-block")
                .html("Win or Loss" + "<br>" + "Frequency");
          })
                .on('mouseout', function () {
                  d3.select(this)
                    .styles({
                      'fill': 'gray',
                      'fill-opacity': '0.7'});
            toolTip
               .style("display", "none");
            
                });
          
            }
          

            function update(firstCall) {
              updateScales();
              updateAxes(firstCall);
              updateBars();
            }

            function initEvents() {
              // Set up event handler for resizes
              W.addListener(update);
            }

            initChart();
            update(true); // set parameter `firstCall` to true this once
            initEvents();
          });

        </script>
        </div>
        </svg>
        </div> 
     ending for bar graph-->
	
</div>
</body>
</html>

