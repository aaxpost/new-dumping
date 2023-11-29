<?php
//Загрузка библиотеки для парсинга
require_once ('./vendor/autoload.php');
use DiDom\Document;
use Didom\Query;

//Можно передать только один паттерн, если так будет проще
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