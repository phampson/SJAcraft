<?php
include('/home/ubuntu/ECS160WebServer/start.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
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
  <link rel="stylesheet" href="stylesheet.css">
  <link rel="stylesheet" href="../stylesheet.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

</script>
<!-- Nav Bar -->
<div id="navbar"></div>
<?php
echo "<script>\n";
echo '$("#navbar").load("' . $navpath . '")';
echo "</script>\n";
?>


<div id = "container" class="container">
  <div id = "bannerctnr">
    <h1>Install tools</h1> 
  </div>

  <table>
  <tr>
      <td><h2>Tool 1</h2></td>
      <td><input type="image" src="../img/downloadTools.png" name="tool1" class="btTxt submit" id="tool1" style="width:125px"/> </td>
    </tr>
    <tr>
      <td><h2>Tool 2</h2></td>
      <td><input type="image" src="../img/downloadTools.png" name="tool2" class="btTxt submit" id="tool2" style="width:125px"/> </td>
    </tr>
    <tr>
      <td><h2>Tool 3</h2></td>
      <td><input type="image" src="../img/downloadTools.png" name="tool3" class="btTxt submit" id="tool3" style="width:125px"/> </td>
    </tr>
  </table>

  </div>
</div>

</body>
</html>
