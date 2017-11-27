<?php
if (!extension_loaded('curl')) {
    echo 'failed';
} 
else {
    echo 'loaded';
}
error_reporting(E_ALL);
ini_set('display_errors', '1');
$name   = "XU";
$url    = "http://34.214.129.0/login/multi/index.php?name=XU";
$client = curl_init($url);
curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($client);
echo $response;
?>
