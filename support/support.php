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
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II-Support Page</title>
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

<div class="container">
<h1>Support Page</h1><hr>
<div class="container">
	<div class="panel-group" id="accordion">

<?php 
        echo "<div class='panel panel-default'>
		  		<div class='div1 panel-heading'>
				    <h3 class='panel-title'>
				    	<a data-toggle='collapse' data-parent='#accordion' href='#collapse1'>
				        <font color='white'><center>Bug Title</center></font></a>
				    </h3>
		    	</div>
		    	<div id='collapse1' class='div2 panel-collapse collapse'>
				    <p class='panel-body'>In this paragraph, you would put the text describing the bug</p>
				    <button class='btn-simple btn-sm'><a  style='color:white;' href='support.php'>Delete</a></button>
                <button class='btn-simple btn-sm'><a  style='color:white;' href='support.php'>Resolve</a></button>
			    </div>
	  		</div>";
	  		
	  	echo "<div class='panel panel-default'>
		  		<div class='div1 panel-heading'>
				    <h3 class='panel-title'>
				    	<a data-toggle='collapse' data-parent='#accordion' href='#collapse2'>
				        <font color='white'><center>For backend</center></font></a>
				    </h3>
		    	</div>
		    	<div id='collapse2' class='div2 panel-collapse collapse'>
				    <p class='panel-body'>You will likely make a loop of these echo statements when iterating through database. This post assumes you can't see the delete and resolve buttons since you are not admin</p>
			    </div>
	  		</div>";
	  		
	  	echo "</div>";
            
      echo "<button class='btn-simple btn-sm' style='margin-left:75%'><a  style='color:white;' href='submit.php'>Submit New Error</a></button>";
?>
</div>
</div>
</body>
</html>
