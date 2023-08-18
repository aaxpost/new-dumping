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





      //Приближаюсь к универсальной функции
        $href = 'https://agro-club.com.ua/ua/p1108689491-krossovyj-mototsikl-250.html';
        if (strlen($href) > 4) {
          $document = new Document(curlFunc($href));
          if ($document->has('div.b-product-cost')) {
            echo $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();exit;
          } else {
            echo "error";
          }  
        } else {
          echo "no href";
        }
        exit;






        
        //if (empty($document)) {echo "array empty";}
        //var_dump($document);
        //exit;
        //рабочий код для прома

        echo $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();exit;
        //$price_1 = $document->find('div.inf-block.ib-price')->first('span.price.stock')->text();exit;
        if (count($document->find('*[^data-=product_price]')) > 0) {
            $price_1 = $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();
        } else {
            $price_1 = 999999;
        }
        if (count($document->find('span.price')) > 0) {
          $price_2 = $document->find('div.b-product-cost')[0]->first('span.price')->text();
        } else {
            $price_2 = 999999;
        }
        if ($price_1 == 999999 AND $price_2 == 999999) {
          $price = 'er_pars';
        } else {
          $price = min($price_1, $price_2);
        }
        echo $price;
        
        

      
   

    
