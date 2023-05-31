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
use Didom\Query;

//Загрузка функции
require ('function/curlFunc.php');

$url = 'https://dnepr-traktor.net/ua/p509617504-izmelchitel-vetok-pod.html';
$siteFile = curlFunc($url);

$siteDoc = new Document($siteFile);
$elem = $siteDoc->find('.b-product-cost__price');

//var_dump($block);
//$price = $elem->text();
//var_dump($price);
//b-product-cost
/*
if ($elem->has('span')) {
  echo "yes elem";
  $block = $elem->find('span');
}
var_dump($block);
*/


$document = new Document('page.html', true);
var_dump($document);
$block = $document->first('#block');
$elem = $block->first('.elem');
echo $elem->text();




