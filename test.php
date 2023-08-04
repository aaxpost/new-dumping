<html>
  <head>
    <title>TEST-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING TEST</h1>
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
//Загрузка зависимостей Google API
require __DIR__ . '/vendor/autoload.php';


//Считываю данные для парсинга из базового листа
      $document = new Document('page.html', true);
      //$document = new Document('https://gectar.com.ua/kartofelekopatel-universalnyy/');
      
      //var_dump(file_get_contents('https://gectar.com.ua/kartofelekopatel-universalnyy/'))."<br>";exit;
      //$price = $document->find('div.b-product-cost');
      //$price = $document->find('div.price');
      //var_dump($price)."<br>";exit;
      $price = $document->find('div.product-info');
      $price = $document->first('div#pr201');
      //$price = $document->first('*[^data-=product_price]');
      
      //$price = $document->first('*[^data-=product_price]');
      //$price = $document->first('h2.h2_price');
      //$price = $document->find('div.ib-price');
      //var_dump($price)."<br>";exit;
      //$price = $document->first('b.data-value-price');
      //var_dump($price)."<br>";
      //var_dump($price)."<br>";exit;
      echo $price->text();exit;

      if ($price == NULL) {
        echo "er href";
      } else {
          $price = stringToNum($price->text());
          echo auditPrice($price);
      } 
   

    
