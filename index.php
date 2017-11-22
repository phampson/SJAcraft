<?php

include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_SESSION['user_id'])){
	$navpath = "navbar/navbarlogged.html";
}
else{
	$navpath = "navbar/navbar.html";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

<div id="outerctn" class="container col-xs-12 col-xs-offset-0"

     <!-- Banner -->
    <img class="banner" src="img/SplashMirror.png">

     <!-- Logo -->
     <div class="container logoctn col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-4">
        <img class="logo" src="img/Logo.png">
     </div>     
   
    <br>

     <!-- Play Button -->
    <div class="container btnctn col-xs-4 col-xs-offset-4 col-sm-2 col-sm-offset-5">
     <button type="button" class="btn btn-fancy-play">Play Now</button>
    </div>

	<!-- Leader Board -->
	<div class="leaderboard container col-xs-12 col-sm-8 col-sm-offset-2">
		<h2 class="text-center">Leader Board</h2>
		<div id="leaderboard"></div>
		<br>
	</div>
</div>

</body>

<!-- Load Leaderboard -->
<script>
        var users;

        // Request top 10 users by ELO
        jQuery.extend({
            GetUsers: function(type, lim) {
                var result = null;
                $.ajax({
                    method: "POST",
                    url: "leaderboard/leaderboard.php",
                    async : false,
                    data: { order: type, limit: lim },
                    dataType: "json",
                    success: function(data) {
                        result = data;
                   }
               });
               return result;
            }
        });
        var users = $.GetUsers("ELO", "10");

        for(var i in users) {
		pos = parseInt(i) + 1;
	
                var html_string = ' \
		<hr> \
                <div class="row"> \
                        <div class="col-xs-3"> \
                                <h4 class="text-right">' + pos + '</h4> \
                        </div> \
                        <div class="col-xs-8"> \
                                <div class="media"> \
                                        <div class="media-left"> \
                                                <img src="./img/default.png" class="media-object" style="width:60px"> \
                                        </div> \
                                        <div class="media-body"> \
                                                <h4 class="media-heading">' + users[i].name + '</h4> \
                                                <p>ELO: ' + users[i].ELO + '</p> \
                                        </div> \
                                </div> \
                        </div> \
                        <div class="col-xs-1"> \
                        </div> \
                </div>';

                document.getElementById("leaderboard").insertAdjacentHTML('beforeend', html_string);
        }

</script>
</html>
