<?php
// Jon's alternate homepage design

include('/home/ubuntu/ECS160WebServer/start.php');

if (isset($_SESSION['user_id'])) {
    $navpath = "navbar/navbarlogged.html";
} 
else {
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

<div class="bg">
    <div class="text-center" style="position: relative; left: 0; top: 20%; width: 100%;">
        <img src="img/Logo.png" class="logo">
        <br><br><br>
        <a href="./downloadgame/downloadgame.php" class="btn btn-fancy-play" role="button"></a>
    </div>
</div>
</body>

<!-- Load Leaderboard -->
<script>
    	function go()
    	{window.location.href = './downloadgame/downloadgame.php'; }
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
            var html_string = '' +
            '<tr> ' +
                '<td>' +
                    '<img align="left" src="../profile/'+ users[i].avatar_path +'" style="width:60px;height:60px;"></img>' +
                    '<h3><a href="http://' + "<?php
echo $_SERVER['HTTP_HOST'];
?>" + '/profile/profile.php?id=' + users[i].id + '"> ' + users[i].name + '</a></h3>' +
                '</td>' +
            '</tr>';

            //document.getElementById("leaderboard").insertAdjacentHTML('beforeend', html_string);
        }

</script>
</html>
