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
      //
        $href = 'https://moimotoblok.com.ua/motoblok-forte-md-81-lux';
        if (strlen($href) > 4) {
          //получаю строку с кодом
          $strHtml = curlFunc($href);
          //Если строка пустая, защита сайта, вывожу ошибку
          if (!empty($strHtml)) {
            $document = new Document($strHtml);
            if ($document->has('div.b-product-cost')) {
              echo $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();exit;
            } else {
              echo "error";
            }
          } else {
            echo "site_error";
          }
        } else {
          echo "no_href";
        }
        










        

        
        

      
   

    
