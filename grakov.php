<html>
  <head>
    <title>NEW-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING ГРАКОВ РАБОЧИЙ</h1>
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


//Подготовка объекта для записи данных в лист
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

//Нулевая строка, технические данные: дата запроса и фамилия менеджера
gSheetInsert([date(DATE_RFC822), 'Граков'], $client);

//Считываю данные для парсинга из базового листа
//Измельчители
$href = 'https://docs.google.com/spreadsheets/d/1AKDsFSFQlI-mbH4rSRyXM3_78bCJdUGJoSkQIe6eFNo/edit#gid=1894254733';
//Кит наборы
//$href = 'https://docs.google.com/spreadsheets/d/1AKDsFSFQlI-mbH4rSRyXM3_78bCJdUGJoSkQIe6eFNo/edit#gid=1516206833';
//Часнокосажалки
//$href = 'https://docs.google.com/spreadsheets/d/1AKDsFSFQlI-mbH4rSRyXM3_78bCJdUGJoSkQIe6eFNo/edit#gid=120254664';
//ТЕСТ
//$href = 'https://docs.google.com/spreadsheets/d/1AKDsFSFQlI-mbH4rSRyXM3_78bCJdUGJoSkQIe6eFNo/edit#gid=1061767132';

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
    
    //https://agrokram.com/*
    $i = 2;
    $elems[$i] = "no code";

    //https://mototraktor.net/*
    $i = 3;
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

    //https://dnepr-traktor.net/*
    $i = 4;
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

    //https://natraktor.com/*
    $i = 5;
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

     //https://mbtop.com.ua/*
     $i = 6;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price_1 = $document->find('li.list-unstyled.price');
      $price_1 = $document->first('span.price-new');
      $price_2 = NULL;
      if ($price_1 == NULL AND $price_2 == NULL) {
        $elems[$i] = "er href";
      } else {
        if ($price_1 == NULL) {
          $price_1 = 999999;
        } else {
          $price_1 = stringToNum($price_1->text());
        }
        if ($price_2 == NULL) {
          $price_2 = 999999;
        } else {
          $price_2 = stringToNum($price_1->text());
        }
        $elems[$i] = auditPrice($price_1, $price_2);
      }
    } else {
      $elems[$i] = "no href";
    }

    //https://agroambar.com/*
    $i = 7;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->first('p.catalog_item-price-actual');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //https://vladgreenline.com/*
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

    //https://mentol.in.ua/*
    $i = 9;
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

    //https://romb.ua/*
    $i = 10;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
      $price = $document->find('div.price-box.price-final_price');
      $price = $document->first('span.price');
      if ($price == NULL) {
        $elems[$i] = "er href";
      } else {
        $price = stringToNum($price->text());
        $elems[$i] = auditPrice($price);
      }
    } else {
      $elems[$i] = "no href";
    }

    //https://avtogeshik.com.ua/*
    $i = 11;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
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

    //https://mechanikus.com.ua/*
    $i = 12;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
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

    //https://sklad310.com/*
    $i = 13;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
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

    //https://allex.pro/*
    $i = 14;
    if (strlen($elems[$i]) > 4) {
      $document = new Document(curlFunc($elems[$i]));
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

     //https://notre.com.ua/*
     $i = 15;
     if (strlen($elems[$i]) > 4) {
       $document = new Document(curlFunc($elems[$i]));
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
    //Запрос на внесение в таблицу строки данных по одному артикулу
    gSheetInsert($elems, $client);
  }
}
