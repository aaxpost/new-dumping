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
        $href = 'http://old.kruchkov.com.ua/katalog/gruntozacep/gruntozatsep-pubert-340-ko2';
        if (strlen($href) > 4) {
          //получаю строку с кодом
          $strHtml = curlFunc($href);
          //Если строка пустая, защита сайта, вывожу ошибку
          if (!empty($strHtml)) {
            $document = new Document($strHtml);
            if ($document->has('div.product-field-display')) {
              echo $document->find('div.product-field-display')[0]->text();
            } else {
              echo "error";
            }
            if ($document->has('h1.b1c-name.b2c-name')) {
              echo $document->find('h1.b1c-name.b2c-name')[0]->text();
            } else {
              echo "error";
            }
            if ($document->has('div.tab-pane.fade.in.active')) {
              echo $document->find('div.tab-pane.fade.in.active')[0]->html();
            } else {
              echo "error";
            }
          } else {
            echo "site_error";
          }
        } else {
          echo "no_href";
        }

        ////////////////////////
*/        
      









        

        
        

      
   

    
