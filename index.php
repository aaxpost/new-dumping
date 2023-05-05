<html>
  <head>
    <title>Welcome to your_domain_1!</title>
  </head>
  <body>
    <h1>Success! The new-dumping virtual host is working!</h1>
    <h1>Success! First commit</h1>
  </body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require ('function/curlFunc.php');

$url = 'https://dnepr-traktor.net/ua/p509617504-izmelchitel-vetok-pod.html';

echo curlFunc($url);