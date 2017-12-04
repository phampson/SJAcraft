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
        $admin = $fetch['admin'];
    }
}
else {
    $navpath = "../navbar/navbar.html";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II Support</title>
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

<div class="div1 container" id="border-gold">
<h1>Support</h1><hr>
<div class="col-xs-12 col-sm-10 col-sm-offset-1">
	<div class="panel-group" id="accordion">

<?php 
	
	$sql = 'SELECT bug_id, title, details, resolved FROM support';
	$result = $mysqli->query($sql) or die(mysqli_error($mysqli));
    	
    $pos = 1;
	while ($row = $result->fetch_row()) {
        $bugID  		= $row[0];
        $title  		= $row[1];
        $details	    = $row[2];
        $resolved 		= $row[3];
        
        if($resolved == "true") {
        	$status = '<span style="color: green;" class="pull-right glyphicon glyphicon-ok"></span>';
        } else {
        	$status = '<span style="color: red;" class="pull-right glyphicon glyphicon-hourglass"></span>';
        }
    
        echo "<div class='panel panel-default'>
		  		<div class='panel-heading'>
				    <div class='panel-title'>
				    	<a data-toggle='collapse' data-parent='#accordion' href='#collapse$pos'>
				        <center>$title $status</center></a>
				    </div>
		    	</div>
		    	<div id='collapse$pos' class='panel-collapse collapse'>
				    <div class='panel-body text-center'>$details</div>";

				    if (isset($admin)) {

                        if($admin==1 && $resolved != 'true') {
                            echo"<div class='text-center'>
                                <button class='btn btn-default'><a href='resolve.php?bugID=$bugID'>Resolve</a></button>
                            </div>";
                        }

                    }
			    echo"</div>
	  		</div>";
	  	$pos++;
	}
	  		
	  	echo "</div>";
            
      echo "<a href='submit.php' class='btn-simple' role='button'><input type='submit' class='btn-simple' value='Submit New Error' name='submit' style='width:150px'></a>";
		
?>
    </div>
</div>
</body>
</html>
