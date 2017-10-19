<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
   echo $_SESSION['user_id'];
}
else{echo"nothing";}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Warcraft II-Forum</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../stylesheet.css">
	<link rel="stylesheet" href="stylesheet.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Nav Bar -->
<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="../index.html">WarCraft II</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li><a href="#">About</a></li>
				<li class="">
					<a class="dropdown-toggle" data-toggle="dropdown"href="#">Download
					<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="../downloadthegame/downloadthegame.html">Download the game</a></li>
						<li><a href="../dlc/dlc.php">Download maps</a></li>
					</ul>
				</li>
				<li><a href="../faq/faq.html">FAQ</a></li>
				<li class="active"><a href="#">Forum</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="../signup/signup.html"> Sign Up</a></li>
				<li><a href="../login/login.html"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
			</ul>
		</div>
	</div>
</nav>

<div>
	<h1>Forums</h1>
	<div class="container">
		<nav class="navbar navbar-inverse">
			<form class="navbar-form navbar-left">
				<div class="input-group">
				    <input type="text" class="form-control" placeholder="Search Threads/Users">
					    <div class="input-group-btn">
						    <button class="btn btn-default" type="submit">
						    	<i class="glyphicon glyphicon-search"></i>
						    </button>
					    </div>
  				</div>
			</form>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#"><span class="glyphicon glyphicon-plus"></span> Start New Discussion </a></li>
			</ul>
		</nav>
	</div>
</div>

<div class="container">
	<table class="table table-hover">
	    <thead>
		    <tr>
		        <th style="font-size: 20px;">Discussions</th>
		        <th style="text-align: right; font-size: 16px;">Threads</th>
		        <th style="text-align: right; font-size: 16px;">Posts</th>
		        <th style="text-align: right; font-size: 16px;">Latest Activity</th>
		    </tr>
	    </thead>
	    <tbody>
		    <tr>
		        <td><a href="#"><strong>Beginners</strong></a></td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">10/07/17</td>
		    </tr>
		    <tr>
		        <td><a href="#"><strong>Strategies</strong></a></td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">10/07/17</td>
		    </tr>
		    <tr>
		        <td><a href="#"><strong>Maps</strong></a></td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">10/07/17</td>
		    </tr>
		    <tr>
		        <td><a href="#"><strong>Game Updates</strong></a></td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">10/07/17</td>
		    </tr>
		    <tr>
		        <td><a href="#"><strong>General</strong></a></td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">0</td>
		        <th style="text-align: right;">10/07/17</td>
		    </tr>
		</tbody>
	</table>
</div>
<script>

</script>
</body>
</html>
