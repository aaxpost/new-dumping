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









        
//$href = 'https://fermerplus.com.ua/ua/p787884282-drovokol-izmelchitel-vetok.html';
//$href = 'https://agrotehnic.com.ua/ua/izmelchitel-vetok-drovokol-dlya-minitraktora-bez-konusa-odnostoronnyaya-zatochka-nozhej.html';
$href = 'https://motoblok24.com.ua/drovokoly/tproduct/506651364-677832190351-drovokol-podrbnyuvach-glok-pd-motoblok-z';
$elems = [$href];
$i = 0;

//Если не работает сайт, если нет ссылки, если не спарсилось, если нет элемента

function getPrice ($elems, $i, $pattern_1, $pattern_2 = '') {
  if (strlen($elems[$i]) > 4) {
    //получаю строку с кодом
    $strHtml = curlFunc($elems[$i]);
    //var_dump($strHtml);
    //Если строка пустая, защита сайта, вывожу ошибку
    if (!empty($strHtml)) {
      $document = new Document($strHtml);
      if ($document->has($pattern_1)) {
          if (strlen($pattern_2 > 4)) {
              $price = $document->find($pattern_1)[0]->first($pattern_2)->text();
            } else {
              $price = $document->find($pattern_1)[0]->text();
            }
      } else {
        $price = "error";
      } 
    } else {
      $price = "site_error";
    }
  } else {
    $price = "no_href";
  }
  $price = stringToNum($price);
  return $price;
}

//echo "1:".getPrice ($elems, $i, 'span.autocalc-product-special');
echo "2:".getPrice ($elems, $i, 'div.t-store__prod-popup__price-item.t-name.t-name_md');












        

        
        

      
   

    
