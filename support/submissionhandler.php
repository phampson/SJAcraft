<?php
// Imports & Error Reporting
include('/home/ubuntu/ECS160WebServer/start.php');
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

$id = $_SESSION['user_id'];
$title = $_POST['title'];
$details = $_POST['details'];

if(($title == "") || ($details == "")) {
	header('Location: ' . '../support/submit.php');
} 

$sql = "insert into support (user_id, title, details)values('$id','$title','$details')";

if($mysqli->query($sql))
	{echo "";}
else{echo $sql."";}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Submit An Error</title>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
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

<div class='div1 col-xs-12 col-sm-8 col-xs-offset-0 col-sm-offset-2' id='border-gold'>

<?php echo 
	"<h2>Thank you for your Submission!</h2>
    <p>Our administrators will notify you by e-mail when your submission has been resolved.</p>";
	echo "<a href='support.php' class='btn-simple' role='button'><input type='submit' class='btn-simple' value='Support' name='submit' style='width:150px'></a>";
?>

</div>
</body>
</html>
