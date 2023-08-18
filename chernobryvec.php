<html>
  <head>
    <title>NEW-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING ЧЕРНОБРЫВЕЦ РАБОЧИЙ</h1>
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
//Загрузка зависимостей Google API
require __DIR__ . '/vendor/autoload.php';


//Подготовка объекта для записи данных в лист
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

//Нулевая строка, технические данные: дата запроса и фамилия менеджера
gSheetInsert([date(DATE_RFC822), 'Чернобрывец'], $client);

//Считываю данные для парсинга из базового листа
$href = 'https://docs.google.com/spreadsheets/d/1t3mGM9aYTMN5UApPhhe2craUmKRfO1LNGsO-Kd-uTNg/edit#gid=2023262523';
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
    
    //https://motoblok-pro.com.ua/*
    $i = 2;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('ul.list-unstyled.price')[0]->first('li')->text();
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price);
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //https://ftech.in.ua/*
    $i = 3;
    $elems[$i] = "no code";

    //https://fermerplus.com.ua/*
    $i = 4;
    $elems[$i] = "error";
    /*
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      //prom.ua
      $price = $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price);
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }
    */

    //https://pum.in.ua/*
    $i = 5;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));

      if (count($document->find('span.price.stock')) > 0) {
        $price_1 = $document->find('div.inf-block.ib-price')[0]->first('span.price.stock')->text();
      } else {
          $price_1 = 999999;
      }
      if (count($document->find('span.price')) > 0) {
        $price_2 = $document->find('div.inf-block.ib-price')[0]->first('span.price')->text();
      } else {
          $price_2 = 999999;
      }
      if ($price_1 == 999999 AND $price_2 == 999999) {
        $price = 'er_pars';
      } else {
        $price = min($price_1, $price_2);
      }
      $elems[$i] = stringToNum($price);
    } else {
      $elems[$i] = "no href";
    }

     //https://mangalshop.com.ua/*
     $i = 6;
     if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.product-price__box')[0]->first('div.product-price__item')->text();
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price);
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //https://teploreal.com.ua/*
    $i = 7;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      //prom.ua
      $price = $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price);
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //https://agro-club.com.ua/*
    $i = 8;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.b-product-cost')[0]->first('*[^data-=product_price]')->text();
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price);
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //Запрос на внесение в таблицу строки данных по одному артикулу
    gSheetInsert($elems, $client);
  }
}
