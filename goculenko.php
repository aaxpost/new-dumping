<html>
  <head>
    <title>NEW-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING ГОЦУЛЕНКО РАБОЧИЙ</h1>
  </body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//phpinfo();exit;

//Максимальное время выполнения скрипта
ini_set('max_execution_time', '10000');
set_time_limit(0);
ini_set('memory_limit', '2048M');
ignore_user_abort(true);

//Загрузка библиотеки для парсинга
require_once ('./vendor/autoload.php');
use DiDom\Document;
use Didom\Query;

//Загрузка функций
require ('function/curlFunc.php');
require ('function/gSheetRead.php');
require ('function/gSheetInsert.php');
require ('function/stringToNum.php');
require ('function/auditPrice.php');
require ('function/getPrice.php');
//Загрузка зависимостей Google API
require __DIR__ . '/vendor/autoload.php';


//Подготовка объекта для записи данных в лист
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

//Нулевая строка, технические данные: дата запроса и фамилия менеджера
gSheetInsert([date(DATE_RFC822), 'Гоцуленко'], $client);

//Считываю данные для парсинга из базового листа
//Подрібнювачі
//$href = 'https://docs.google.com/spreadsheets/d/1-15jXOYKGdQU00yHdQItbMHN23OEJjVsUlok-RsmLbs/edit#gid=834283077';
//ТЕСТ
//$href = 'https://docs.google.com/spreadsheets/d/1-15jXOYKGdQU00yHdQItbMHN23OEJjVsUlok-RsmLbs/edit#gid=299108438';
//Кіт набори
$href = 'https://docs.google.com/spreadsheets/d/1-15jXOYKGdQU00yHdQItbMHN23OEJjVsUlok-RsmLbs/edit#gid=501230981';
//Чеснокосажалки
//$href = 'https://docs.google.com/spreadsheets/d/1-15jXOYKGdQU00yHdQItbMHN23OEJjVsUlok-RsmLbs/edit#gid=1198811805';
//ТЕСТ
//$href = 'https://docs.google.com/spreadsheets/d/1-15jXOYKGdQU00yHdQItbMHN23OEJjVsUlok-RsmLbs/edit#gid=299108438';

$array = gSheetRead($href);

foreach ($array as $key => $elems) {
  //1 ROW Строка с артикулом и именем партнера или ссылкой на сайт
  if ($key == 0) {
    gSheetInsert($elems, $client);
  }
  //Все остальные строки
  if ($key != 0) {
    //KRUCHKOV
    if (strlen($elems[1]) > 4) {
      $document = new Document(curlFunc($elems[1]));
      $kruchkov_price = $document->first('h2.h2_price');
      if ($kruchkov_price == NULL) {
        $elems[1] = "er href";
        } else {
          $kruchkov_price = stringToNum($kruchkov_price->text());
          $elems[1] = auditPrice($kruchkov_price);
      } 
    } else {
      $elems[1] = "no href";
    }
    
    //MOIMOTOBLOK*
    $i = 2;
    $elems[$i] = "error";
    /*
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->first('div.price');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }
    */

    //MOYA-FAZENDA*
    $i = 3;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->first('span#block_price');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //AGRODID*
    $i = 4;
    $elems[$i] = getPrice ($elems, $i, 'p.price', 'bdi');

    //GECTAR*
    $i = 5;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.price');
      $price = $document->first('span.price1');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //Agrotehnik*
    $i = 6;
    $elems[$i] = getPrice ($elems, $i, 'span.autocalc-product-special');
   
    //Dokamir
    $i = 7;
    $elems[$i] = getPrice ($elems, $i, 'div#pr201', 'span.price-new');
    
    //Запрос на внесение в таблицу строки данных по одному артикулу
    gSheetInsert($elems, $client);
  }
}
