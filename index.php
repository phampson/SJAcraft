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
<body class="bg">

<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<div class="container text-center">
    <!-- Logo -->
    <img class="logo" src="img/Logo.png" style="width:300px;">
    <br><br><br><br>
    <!-- Play Button -->
    <button type="button" class="btn btn-fancy-play"></button>
    <br><br><br><br>
</div>

<!-- Leader Board -->
<div class="div1 container col-xs-12 col-sm-8 col-sm-offset-2" id="border-gold">
    <h1>Leader Board</h1>
    <hr>
    <table class="table">
        <tbody id="leaderboard"></div>
        </tbody>
    </table>
    <br>
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
            var html_string = ' \
            <tr> \
                <td> \
                    <img align="left" src="../profile/'+ users[i].avatar_path +'" style="width:60px;height:60px;"></img> \
                    <a href="http://' + "<?php echo $_SERVER['HTTP_HOST']; ?>" + '/profile/profile.php?id='+ users[i].id + '"><h3>' + users[i].name + '</h3></a> \
                </td> \        
            </tr>';

            document.getElementById("leaderboard").insertAdjacentHTML('beforeend', html_string);
        }

</script>
</html>
