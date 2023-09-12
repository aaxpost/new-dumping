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

//Считываю данные для парсинга из базового листа
$href = 'https://docs.google.com/spreadsheets/d/14ZCsGhynpRc1jrl5njx23vWdvN-psqvY5lJY304RhHw/edit#gid=0';
$array = gSheetRead($href);
$arrForCsv = [];
//var_dump($array);
$i = 0;
foreach ($array as $elems) {
    if (strlen($elems[0]) > 4) {
      //получаю строку с кодом
      $strHtml = curlFunc($elems[0]);
      //Если строка пустая, защита сайта, вывожу ошибку
        if (!empty($strHtml)) {
        $document = new Document($strHtml);
            if ($document->has('div.product-field-display')) {
                $elems[0] = $document->find('div.product-field-display')[0]->text();
                } else {
                $elems[0] = "error";
            }
            if ($document->has('h1.b1c-name.b2c-name')) {
                $elems[1] = $document->find('h1.b1c-name.b2c-name')[0]->text();
                } else {
                $elems[1] = "error";
            }
            if ($document->has('div.tab-pane.fade.in.active')) {
                $elems[2] = $document->find('div.tab-pane.fade.in.active')[0]->html();
                } else {
                $elems[2] = "error";
            }
         }
}
    //Запрос на внесение в таблицу строки данных по одному артикулу
    //gSheetInsert($elems, $client);
    echo "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
    $arrForCsv[$i] = $elems;
    $i++;
    var_dump($elems);
    
  }
createCsvFile($arrForCsv, 'descr.csv');
