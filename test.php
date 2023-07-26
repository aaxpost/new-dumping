<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//Загрузка библиотеки для парсинга
require_once ('./vendor/autoload.php');
use DiDom\Document;
use Didom\Query;

//Загрузка функций
require ('function/curlFunc.php');

$url = 'https://kruchkov.com.ua/kartoplekopach/kartoplekopach-universalnij-kk1';
$document = new Document($url, true);
//Регулярная цена на нашем сайте
$elemPrice = $document->first('h2.h2_price');
echo $elemPrice->text();
//echo "<br>".$elem->text(); 


//var_dump(htmlspecialchars($elem->attr('type')));
/*
$i = 0;
foreach ($elem as $item) {
  $arr[$i][] = $item->attr('href');
  $arr[$i][] = $item->text();
  $i = $i + 1;
}
var_dump($arr);
echo '<pre>';
echo var_export($arr);
echo '</pre>';
*/
