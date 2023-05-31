<html>
  <head>
    <title>NEW-DUMPING WORK</title>
  </head>
  <body>
    <h1>Success! The new-dumping virtual host is working!</h1>
    <h1>Success! First commit</h1>
  </body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//Загрузка библиотеки для парсинга
require_once ('./vendor/autoload.php');
use DiDom\Document;

//Загрузка функции
require ('function/curlFunc.php');

$url = 'https://dnepr-traktor.net/ua/p509617504-izmelchitel-vetok-pod.html';
$siteFile = curlFunc($url);

$siteDoc = new Document('page.html', true);

$result = $siteDoc->first('div');

//var_dump($result);
echo $result->text();


