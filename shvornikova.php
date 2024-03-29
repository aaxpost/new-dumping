<html>
  <head>
    <title>NEW-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING ШВОРНИКОВА РАБОЧИЙ</h1>
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
gSheetInsert([date(DATE_RFC822), 'Шворникова'], $client);

//Считываю данные для парсинга из базового листа
//Подрібнювачі
//$href = 'https://docs.google.com/spreadsheets/d/1L6ocwvrGk9Uy1RsaAyYFLCzhrKUEtCyGfwlHMmc6vGw/edit#gid=839305164';
//Кіт-набори
//$href = 'https://docs.google.com/spreadsheets/d/1L6ocwvrGk9Uy1RsaAyYFLCzhrKUEtCyGfwlHMmc6vGw/edit#gid=712333605';
//Часникосаджалки
//$href = 'https://docs.google.com/spreadsheets/d/1L6ocwvrGk9Uy1RsaAyYFLCzhrKUEtCyGfwlHMmc6vGw/edit#gid=219408659';
//ТЕСТ
$href = 'https://docs.google.com/spreadsheets/d/1L6ocwvrGk9Uy1RsaAyYFLCzhrKUEtCyGfwlHMmc6vGw/edit#gid=270595482';
//Картоплесаджалки
//$href = 'https://docs.google.com/spreadsheets/d/1L6ocwvrGk9Uy1RsaAyYFLCzhrKUEtCyGfwlHMmc6vGw/edit#gid=659186658';

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
    
    //PROFTOOLS
    if (strlen($elems[2]) > 4) {
      $document = new Document(curlFunc($elems[2]));
      $price = $document->find('div.b-product-cost');
      $price = $document->first('*[^data-=product_price]');
      if ($price == NULL) {
        $elems[2] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[2] = auditPrice($price);
      }
    } else {
      $elems[2] = "no href";
    }

    //FERMEROK
    /*
    if (strlen($elems[3]) > 4) {
      $document = new Document(curlFunc($elems[3]));
      $price = $document->first('div.product-price__item');
      if ($price == NULL) {
        $elems[3] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[3] = auditPrice($price);
      }
    } else {
      $elems[3] = "no href";
    }
    */
    //Сайт недоступен, формулы не настроены, внес для проверки
    $i = 3;
    $elems[$i] = getPrice ($elems, $i, 'div.product-price__item');

    //DOM-AGRO
    /*
    if (strlen($elems[4]) > 4) {
      $document = new Document(curlFunc($elems[4]));
      $price = $document->find('div.b-product-cost');
      $price = $document->first('*[^data-=product_price]');
      if ($price == NULL) {
        $elems[4] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[4] = auditPrice($price);
      }
    } else {
      $elems[4] = "no href";
    }
    */
    //Сайт недоступен, формулы не настроены, внес для проверки
    $i = 4;
    $elems[$i] = getPrice ($elems, $i, 'div.b-product-cost', 'data-=product_price');

    //AGRO-PLUS
    if (strlen($elems[5]) > 4) {
      $document = new Document(curlFunc($elems[5]));
      $price = $document->find('div.ib-price');
      $price = $document->first('span.price');
      if ($price == NULL) {
        $elems[5] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[5] = auditPrice($price);
      }
    } else {
      $elems[5] = "no href";
    }

     //AGROVEKTOR
     if (strlen($elems[6]) > 4) {
      $document = new Document(curlFunc($elems[6]));
      $price = $document->first('b.data-value-price');
      if ($price == NULL) {
        $elems[6] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[6] = auditPrice($price);
      }
    } else {
      $elems[6] = "no href";
    }

    //GARDEN-S
    //Настроил 6/02/2024 на проверке
    $i = 7;
    $elems[$i] = getPrice ($elems, $i, 'div.b-product-cost', 'p.b-product-cost__price');

    //MAISTER-OK
    $i = 8;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.b-product-cost');
      $price = $document->first('*[^data-=product_price]');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //GARDENSHOP
    $i = 9;
    $elems[$i] = getPrice ($elems, $i, 'span.the_prod_price');
    /*
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->first('span.the_prod_price');
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

    //TEHNARIK
    $i = 10;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.b-product-cost');
      $price = $document->first('*[^data-=product_price]');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //TRADEHOUSE
    $i = 11;
    $elems[$i] = getPrice ($elems, $i, 'p.b-product-cost__price');

    //MOTOBLOK-24
    $i = 12;
    $elems[$i] = getPrice ($elems, $i, 'div.t-store__prod-popup__price-item.t-name.t-name_md');
    

    //VSE-MOTOBLOKI
    $i = 13;
    $elems[$i] = getPrice ($elems, $i, 'span.woocommerce-Price-amount.amount');

    //AGRO_TOOLS
    $i = 14;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.b-product-cost');
      $price = $document->first('*[^data-=product_price]');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //MOTOKOSMOS
    $i = 15;
    $elems[$i] = getPrice ($elems, $i, 'div.product-price', 'b.int');

    //MINIFERMER
    $i = 16;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->first('li.price-product');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //OPT
    $i = 17;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.b-product-cost');
      $price = $document->first('*[^data-=product_price]');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //AGROFAKTOR
    $i = 18;
    $elems[$i] = getPrice ($elems, $i, 'span.price__value.notranslate');

    //AM.UA
    $i = 19;
    $elems[$i] = getPrice ($elems, $i, '.ty-price-num');
 
    //Запрос на внесение в таблицу строки данных по одному артикулу
    gSheetInsert($elems, $client);
  }
}
