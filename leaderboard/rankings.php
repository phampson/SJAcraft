<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if(isset($_SESSION['user_id'])){
        $navpath = "../navbar/navbarlogged.html";
}
else{
        $navpath = "../navbar/navbar.html";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
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

<div class="container col-xs-12 col-xs-offset-0">
	<!-- Leader Board -->
	<div class="container col-xs-12 col-sm-8 col-sm-offset-2" style="background-color:white">
		<h2 class="text-center">Rankings</h2>
		<div id="leaderboard"></div>

        <div class="row">
            <div class="col-xs-5 col-xs-offset-7">
                <div class="form-group">
                    <label for="order-by">Order By:</label>
                    <select class="form-control" id="order-by">
                        <option value="W">Wins</option>
                        <option value="L">Losses</option>
                        <option value="E">ELO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-1">
                <p class="text-right">Rank</p>
            </div>
            <div class="col-xs-3 col-xs-offset-1">Player</div>
            <div class="col-xs-1 col-xs-offset-3">W</div>
            <div class="col-xs-1">L</div>
            <div class="col-xs-1">ELO</div>
            <div class="col-xs-1"></div>
        </div>

        <div id="rankings"></div></div>
</div>

</body>

<!-- Load Leaderboard -->
<script>
    
    updateRankings();
    $('#order-by').change(updateRankings);

    function updateRankings() {
        var dropdown = document.getElementById("order-by");
        document.getElementById("rankings").innerHTML = "";

        var val = dropdown.options[dropdown.selectedIndex].value;
        var users;

	// Order By Wins
        if(val == "W") {
        	var xhr = new XMLHttpRequest();
       		xhr.onreadystatechange = function() {
                	if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
                        	users = JSON.parse(this.responseText);
                        	console.log("Inside users: " + users);
                	}
        	};
        	xhr.open("POST", "./leaderboard.php", false);
        	xhr.send();
        	console.log(users);
        } 

	// Order By Losses
	else if(val == "L") {
		var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                                users = JSON.parse(this.responseText);
                                console.log("Inside users: " + users);
                        }
                };
                xhr.open("POST", "./leaderboard.php", false);
                xhr.send();
                console.log(users);
        } 

	// Order By ELO
	else if(val == "E") {
		var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                                users = JSON.parse(this.responseText);
                                console.log("Inside users: " + users);
                        }
                };
                xhr.open("POST", "./leaderboard.php", false);
                xhr.send();
                console.log(users);
        }

	// Display
        for(var i in users) {
            var pos = parseInt(i) + 1;

            var html_string = ' \
            <hr> \
            <div class="row"> \
                    <div class="col-xs-1"> \
                        <h4 class="text-right">' + pos + '</h4> \
                    </div> \
                    <div class="col-xs-7"> \
                            <div class="media"> \
                                    <div class="media-left"> \
                                            <img src="../img/default.png" class="media-object" style="width:60px"> \
                                    </div> \
                                    <div class="media-body"> \
                                            <h4 class="media-heading">' + users[i].name + '</h4> \
                                            <p>Rank: ' + users[i].ELO + '</p> \
                                    </div> \
                            </div> \
                    </div> \
                    <div class="col-xs-1">' + users[i].win + '</div> \
                    <div class="col-xs-1">' + users[i].lost + '</div> \
                    <div class="col-xs-1">' + users[i].ELO + '</div> \
                    <div class="col-xs-1"></div> \
            </div>';

            document.getElementById("rankings").insertAdjacentHTML('beforeend', html_string);
        }
    }
</script>
</html>
