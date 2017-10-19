<?php
error_reporting(E_ALL); ini_set('display_errors', '1');
session_start();
if(isset($_SESSION['user_id'])){
   echo $_SESSION['user_id'];
}
else{echo"nothing";}
?>

