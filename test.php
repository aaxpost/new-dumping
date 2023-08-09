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
      //$document = new Document('page.html', true);
      //$document = new Document(curlFunc('https://romb.ua/ua/kartoplekopach-transporternij-premium-kk10.html'));
      
     //var_dump(file_get_contents('https://agrokram.com/kopalki-kartofelja-motoblok-kk-8/'))."<br>";exit;
      //$price = $document->find('div.b-product-cost');
      //$price = $document->find('div.price');
      //var_dump($price)."<br>";exit;
      //$price = $document->find('div.price-buy');
      //var_dump($price)."<br>";
      //itemprop="price"
      
      //var_dump($price)."<br>";exit;
      //$price = $price->nextSibling();
     
      //$price = $document->first('span.price-new');
      //$price = $document->first('*[^data-=product_price]');
      //$price = $document->first('*[^data-=product_price]');
      
      //$price = $document->first('*[^data-=product_price]');
      //$price = $document->first('h2.h2_price');
      //$price = $document->find('div.ib-price');
      //var_dump($price)."<br>";exit;
      //$price = $document->first('b.data-value-price');
      //var_dump($price)."<br>";
      //var_dump($price)."<br>";exit;

        
        $document = new Document(curlFunc('https://agro-club.com.ua/ua/p1767351620-kartofelekopalka-vibratsionnaya-zirka.html'));
        
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
        
        

      
   

    
