<html>
  <head>
    <title>NEW-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING НАЗАРЕНКО</h1>
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
require ('function/auditHref.php');
//Загрузка зависимостей Google API
require __DIR__ . '/vendor/autoload.php';


//Подготовка объекта для записи данных в лист
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

//Нулевая строка, технические данные: дата запроса и фамилия менеджера
gSheetInsert([date(DATE_RFC822), 'Назаренко'], $client);

//Считываю данные для парсинга из базового листа
$href = 'https://docs.google.com/spreadsheets/d/1ByccFLnRlHkoZeWtoVum3fFzWU5LC1Lk87o5ZaC2w2c/edit#gid=1158696318';
$array = gSheetRead($href);

foreach ($array as $key => $elems) {
  //1 ROW Строка с артикулом и именем партнера или ссылкой на сайт
  if ($key == 0) {
    gSheetInsert($elems, $client);
  }
  //Все остальные строки
  if ($key != 0) {
    //KRUCHKOV
    if (auditHref($elems[1])) {
      $document = new Document(curlFunc($elems[1]));
      $kruchkov_price = $document->first('h2.h2_price');
      $kruchkov_price = stringToNum($kruchkov_price->text());
      $elems[1] = auditPrice($kruchkov_price);
    } else {
      $elems[1] = "no href";
    }
    
    //DOMMOTOBLOK
    if (auditHref($elems[2])) {
      $document = new Document(curlFunc($elems[2]));
      $dommotoblok_price = $document->find('div.b-product-cost');
      $dommotoblok_price = $document->first('*[^data-=product_price]');
      if ($dommotoblok_price != NULL) {
        $dommotoblok_price = stringToNum($dommotoblok_price->text());
        $elems[2] = auditPrice($dommotoblok_price);
      } else {
        $elems[2] = "er href";
      }
      
    } else {
      $elems[3] = "no href";
    }

    //Запрос на внесение в таблицу строки данных по одному артикулу
    gSheetInsert($elems, $client);
  }
}
