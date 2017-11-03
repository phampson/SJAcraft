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
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<!-- CSS Styling -->
<style>
  html, body {
  background: url("../img/wowbackground.jpg"), url("../img/texture.png") repeat; 
 background-size: 1500px , auto;
 } 

  .blackbox {
    position:absolute;
    top: 30%;
    left: 50%;
    padding: 40px 40px;
    transform: translate(-50%, -50%);
    width: 1200px;
    height: 200px;
    background: rgba(0,0,0,0.4);

    
  }
  .blackbox h2 {
    display:table-cell;
    vertical-align: middle;
    color: white;
    
  }

  .blackbox p1{
    display:table-cell;
    vertical-align: middle;
    color:white;
  }

  .blackbox2 {
    position:absolute;
    top: 70%;
    left: 50%;
    padding: 50px 40px;
    transform: translate(-50%, -50%);
    width: 1200px;
    height: 200px;
    background: rgba(0,0,0,0.4);
  }

  .blackbox2 h2 {
    display:table-cell;
    vertical-align: middle;
    color: white;
    
  }

  .blackbox2 p1{
    display:table-cell;
    vertical-align: middle;
    color:white;
  }

</style>

<!-- Nav Bar -->
<div id="navbar"></div>
<?php

echo "<script>\n";
        echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>

<div class="blackbox">
  <img align= left src="../img/warcraft.jpg" alt="Warcraft main picture" style="width:100px;height:125px;">
  <b><h2>Introduction</h2></b>
  <p1>Ever since the fall of Azeroth in the First war against the Orc from their homeworld Draenor, the humans of Azeroth have been forced into nearby kingdom of Lordaeron. Together with the elves and Dwarves, the humans formed the Alliance to fight against the Orc who have now set their sights on Lordaeron. You, a human, must defend the kingdom of Lordaeron.</p1>
</div>


<div class="blackbox2">
  <b><h2>How to play</h2></b>
  <p1>You must collect resources by using your tools on the bottom left corner and then clicking on a resourse. You can also make your buildings and units by clicking on the hammer icon, clicking the type of building and placing it on the map. Once you are done, explore unknonwn territory to find your enemies and unleash your units on the enemy buildings. When all the buildings and units are gone from a side, a victor is declared!</p1>
</div>

</body>
</html>
