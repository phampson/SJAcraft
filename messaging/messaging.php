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
                <li class=""><a href="../about/about.php">About</a></li>
                <li class="">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Download
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../downloadgame/downloadgame.php">Download the game</a></li>
                        <li><a href="../dlc/dlc.php">Download maps</a></li>
                    </ul>
                </li>
                <li><a href="../faq/faq.html">FAQ</a></li>
                <li><a href="../forum/forum.php">Forum</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../signup/signup.html"> Sign Up</a></li>
                <li><a href="../login/login.html"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
            </ul>
        </div>
    </div>
</nav>

<!--Chat Window-->
<div>
    <div id="chat_window_1" class="topright">
    	<div class="panel panel-default">
            <div class="panel-heading top-bar">
                <div>
                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat with noob666</h3>
                </div>
            </div>

            <div class="panel-body msg_container_base">
                <div class="row msg_container base_sent">
                    <div class="col-md-10 col-xs-10">
                        <div class="messages msg_sent">
                            <p>Washup dude?</p>
                            <time>You | 5:00pm | 10/25/17</time>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2 avatar">
                        <img src="../img/profpic.png" class=" img-responsive ">
                    </div>
                </div>
                
                <div class="row msg_container base_receive">
                    <div class="col-md-2 col-xs-2 avatar">
                        <img src="../img/profpic.png" class=" img-responsive ">
                    </div>
                    <div class="col-xs-10 col-md-10">
                        <div class="messages msg_receive">
                            <p>Nothin much just collecting some wood</p>
                            <time>noob666 | 8:00pm | 10/25/17</time>
                        </div>
                    </div>
                </div>
                
                <div class="row msg_container base_receive">
                    <div class="col-md-2 col-xs-2 avatar">
                        <img src="../img/profpic.png" class=" img-responsive ">
                    </div>
                    <div class="col-xs-10 col-md-10">
                        <div class="messages msg_receive">
                            <p>wait how do i even move on here???</p>
                            <time>noob666 | 9:24pm | 10/25/17</time>
                        </div>
                    </div>
                </div>

                <div class="row msg_container base_sent">
                    <div class="col-md-10 col-xs-10">
                        <div class="messages msg_sent">
                            <p>wow</p>
                            <time>You | 10:30pm | 10/25/17</time>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-2 avatar">
                        <img src="../img/profpic.png" class=" img-responsive ">
                    </div>
                </div>
                
            </div>
            <div class="panel-footer">
                <div class="input-group">
                    <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" id="btn-chat">Send</button>
                    </span>
                </div>
            </div>
		</div>
    </div>
</div>
</body>
</html>