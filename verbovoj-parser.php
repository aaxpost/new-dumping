<html>
  <head>
    <title>ПАРСЕР ОПИСАНИЙ</title>
  </head>
  <body>
    <h1>NEW-DUMPING ПАРСЕР ОПИСАНИЙ</h1>
  </body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
//exit;
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
require ('function/createCsvFile.php');
//Загрузка зависимостей Google API
require __DIR__ . '/vendor/autoload.php';


//Подготовка объекта для записи данных в лист
/*
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');
*/

//Нулевая строка, технические данные: дата запроса и фамилия менеджера
//gSheetInsert([date(DATE_RFC822), 'Чернобрывец'], $client);

//Считываю данные для парсинга из базового листа
$href = 'https://docs.google.com/spreadsheets/d/14ZCsGhynpRc1jrl5njx23vWdvN-psqvY5lJY304RhHw/edit#gid=0';
$array = gSheetRead($href);
var_dump($array);
foreach ($array as $key => $elems) {
  //1 ROW Строка с артикулом и именем партнера или ссылкой на сайт
  if ($key == 0) {
    //gSheetInsert($elems, $client);
  }
  //Все остальные строки
  if ($key != 0) {
    //АРТИКУЛ
    var_dump('KEY!!!!'.$key);
    $i = 1;
    if (strlen($elems[$i]) > 4) {
      //получаю строку с кодом
      $strHtml = curlFunc($elems[$i]);
      //Если строка пустая, защита сайта, вывожу ошибку
      if (!empty($strHtml)) {
        $document = new Document($strHtml);
        if ($document->has('div.product-field-display')) {
          $elems[$i] = $document->find('div.product-field-display')[0]->text();
        } else {
          $elems[$i] = "error";
        }
      } else {
        $elems[$i] = "site_error";
      }
    } else {
      $elems[$i] = "no_href";
    }
    
    //НАИМЕНОВАНИЕ
    $i = 2;
    if (strlen($elems[$i]) > 4) {
      //получаю строку с кодом
      $strHtml = curlFunc($elems[$i]);
      //Если строка пустая, защита сайта, вывожу ошибку
      if (!empty($strHtml)) {
        $document = new Document($strHtml);
        if ($document->has('h1.b1c-name.b2c-name')) {
          $elems[$i] = $document->find('h1.b1c-name.b2c-name')[0]->text();
        } else {
          $elems[$i] = "error";
        }
      } else {
        $elems[$i] = "site_error";
      }
    } else {
      $elems[$i] = "no_href";
    }

    //ОПИСАНИЕ
    
    $i = 3;
    if (strlen($elems[$i]) > 4) {
      //получаю строку с кодом
      $strHtml = curlFunc($elems[$i]);
      //Если строка пустая, защита сайта, вывожу ошибку
      if (!empty($strHtml)) {
        $document = new Document($strHtml);
        if ($document->has('div.tab-pane.fade.in.active')) {
          $elems[$i] = $document->find('div.tab-pane.fade.in.active')[0]->html();
        } else {
          $elems[$i] = "error";
        }
      } else {
        $elems[$i] = "site_error";
      }
    } else {
      $elems[$i] = "no_href";
    }
    
    //Запрос на внесение в таблицу строки данных по одному артикулу
    //gSheetInsert($elems, $client);
    var_dump($elem);
    //createCsvFile($elems, descr.csv);
  }
}
