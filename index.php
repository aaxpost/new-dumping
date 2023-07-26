<html>
  <head>
    <title>NEW-DUMPING</title>
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

//Загрузка функций
require ('function/curlFunc.php');
require ('function/gSheetRead.php');

$url = 'https://dnepr-traktor.net/ua/p509617504-izmelchitel-vetok-pod.html';
$siteFile = curlFunc($url);
$siteDoc = new Document($siteFile);
$elem = $siteDoc->find('.b-product-cost__price');
$document = new Document('page.html', true);
//var_dump($document);
//Регулярная цена на проме Рабочий код
$elem = $document->find('div.b-product-cost');
$elem = $document->first('*[^data-=product_price]');
echo $elem->text();

$array = gSheetRead();
//echo '<pre>';echo var_export($array);echo '</pre>';exit;

//8888888888888888888888888888888888888888888888888888888
//Код записи данных в таблицу гугл шит
echo "test sheet";
require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
//id листа из урл
$spreadsheetId = "1owRwWJm_SCt18Xi3cMkxaamGLmC1xokYsUEdyHjE94M";
//Название вкладки листа
$range = "sheet_1"; // Sheet name

//Массив, который вставится в строку таблицы
$newArr = [];
foreach ($array as $elems) {
  $elems[0] = $elems[0];
    $url = $elems[1];
    //echo $url;exit;
    $document = new Document($url, true);
    //Регулярная цена на нашем сайте
    $price = $document->first('h2.h2_price');
    //echo $price;exit;
    if (empty($price)) {
      $elems[1] == 'error';
    } else {
      $elems[1] = $price->text();
    }
  $elems[2] = 2;
  $newArr[] = $elems;
  //echo '<pre>';echo var_export($elems);echo '</pre>';
}
//echo '<pre>';echo var_export($newArr);echo '</pre>';exit;

$values = $newArr;
/*
$values = [
	['this is data to insert', 'my name'],
];
*/
//echo "<pre>";print_r($values);echo "</pre>";exit;
$body = new Google_Service_Sheets_ValueRange([
	'values' => $values
]);
$params = [
	'valueInputOption' => 'RAW'
];

$result = $service->spreadsheets_values->append(
	$spreadsheetId,
	$range,
	$body,
	$params
);

if($result->updates->updatedRows == 1){
	echo "Success";
} else {
	echo "Fail";
}


