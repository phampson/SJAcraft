<?php
include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $navpath = "../navbar/navbarlogged.html";
} 
else {
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

<!-- Rankings -->
<div class="div1 container col-xs-12 col-sm-8 col-sm-offset-2" id="border-gold">
	<h1>Rankings</h1>
        <hr>

	<!-- order by select -->
        <div class="form-group">
            <label for="order-by">Order By:</label>
            <select class="form-control" id="order-by">
                <option value="W">Wins</option>
                <option value="L">Losses</option>
                <option value="E">ELO</option>
            </select>
        </div>

	<!-- Table -->
        <table class="table" style="table-layout: fixed">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>W</th>
                    <th>L</th>
                    <th>ELO</th>
		    <th>Rank</th>
                </tr>
            </thead>
            <tbody id="rankings">
            </tbody>
        </table>
</div>

</body>

<!-- Load Rankings -->
<script>
    updateRankings();
    $('#order-by').change(updateRankings);

    function updateRankings() {
        var dropdown = document.getElementById("order-by");
        document.getElementById("rankings").innerHTML = ""; // clear old rankings
        var val = dropdown.options[dropdown.selectedIndex].value; // "W", "L", or "E"
        var users; // array of users ordered by input
        var input; // "win, lost, or ELO"

        // Order By Wins
        if(val == "W") {
            input = "win";
        } 

        // Order By Losses
        else if(val == "L") {
            input = "lost"
        }

        // Order By ELO
        else if(val == "E") {
            input = "ELO"
        }

        // Make Request
        jQuery.extend({
            GetUser: function(type, lim) {
                var result = null;
                $.ajax({
                    method: "POST",
                    url: "leaderboard.php",
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
	    console.log("Input: " + input);
        var users = $.GetUser(input, 1000);
    
        // Display
        console.log(users);

        for(var i in users) {
            var pos = parseInt(i) + 1;
            
            if (users[i].id == 
	        <?php if (isset($_SESSION['user_id'])) { echo $_SESSION['user_id'];}
			else {echo -1;}?>) {
	        var html_string = ' \
            <tr> \
                <td> \
                    <img align="left" src="../profile/'+ users[i].avatar_path +'" style=max-width:100%; display:block;"> \
                    <h3><a href="http://' + "<?php
echo $_SERVER['HTTP_HOST'];
?>" + '/profile/profile.php">' + users[i].name + '</a></h3> \
                </td> \
                <td>' + users[i].win + '</td> \
                <td>' + users[i].lost + '</td> \
                <td>' + users[i].ELO + '</td> \
		<td>' + pos + '</td> \
            </tr>';
	    }
	    else {
            	var html_string = ' \
            <tr> \
                <td> \
                    <img align="left" src="../profile/'+ users[i].avatar_path +'" style=max-width:100%; display:block;"> \
                    <h3><a href="http://' + "<?php
echo $_SERVER['HTTP_HOST'];
?>" + '/profile/profile.php?id='+ users[i].id + '">' + users[i].name + '</a></h3> \
                </td> \
                <td>' + users[i].win + '</td> \
                <td>' + users[i].lost + '</td> \
                <td>' + users[i].ELO + '</td> \
		<td>' + pos + '</td> \
            </tr>';

	    }
            //<img src="../img/default.png" class="media-object" style="width: 60px">
            document.getElementById("rankings").insertAdjacentHTML('beforeend', html_string);
        }
    }
</script>
</html>
