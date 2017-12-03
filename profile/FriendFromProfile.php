<?php

include('/home/ubuntu/ECS160WebServer/start.php');

function phpConsole($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);
    echo "<script>console.log('PHP Console: " . $output . "');</script>";
} // Source: https://stackoverflow.com/questions/4323411/how-can-i-write-to-console-in-php







/*if(isset($_GET['id'])){
$sql = "select * from user_info where id=".$_GET['id'];
$query = $mysqli->query($sql);
if ($query) {
$fetch = $query->fetch_assoc();
$username = $fetch["username"];
$email = $fetch["email"];
$avatarPath = $fetch["avatar_path"];
}
// if GET[ID] is set, you're trying to view someone else's profile,
// so grab their info
}
if(isset($_SESSION['user_id'])){
$navpath = "../navbar/navbarlogged.html";

$sql = 'select * from user_info where id="'.$_SESSION['user_id'].'"';
$query = $mysqli->query($sql);

if (!isset($_GET['id']) and $query) {
// if GET[ID] isn't set, view your own profile so grab your own info
$fetch = $query->fetch_assoc();
$username = $fetch['username'];
$email = $fetch['email'];
$avatarPath = $fetch['avatar_path'];
}
}
else {
//$navpath = "../navbar/navbarlogged.html";
header('Location: ' . '../login/login.html');
}*/

/*$addnewfriend = 'insert into friendlist (user_id,friend_id) value ("'.(int)$_SESSION['user_id'].'","'.$_GET['id'].'");insert into friendlist (user_id,friend_id) value ("'.$_GET['id'].'","'.(int)$_SESSION['user_id'].'")';
$mysqli->multi_query($addnewfriend);*/

$user1      = $_GET["id"];
$user2      = $_SESSION["user_id"];
$addFriend1 = "INSERT INTO friendlist (user_id,friend_id,request) VALUES ('$user1','$user2',1)";
$addFriend2 = "INSERT INTO friendlist (user_id,friend_id) VALUES ('$user2','$user1')";

$mysqli->query($addFriend1) or die("Add friend 1");
$mysqli->query($addFriend2) or die("Add friend 2");
echo "You have a new friend! :-)";

header("Location: profile.php?id=" . $_GET['id']);
?>


