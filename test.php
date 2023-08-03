<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//Загрузка библиотеки для парсинга
require_once ('./vendor/autoload.php');
use DiDom\Document;
use Didom\Query;

//Загрузка функций
//require ('function/curlFunc.php');

function auditPrice($href, $price_1, $price_2 = 999999, $price_3 = 999999) {
  if (strlen($href) < 4) {
    return "no href";
  }
  if (empty($price_1) AND empty($price_2) AND empty($price_3)) {
    return "error";
  } else {
    if (empty($price_1) OR $price_1 == 0) {
      $price_1 = 999999;
    }
    if (empty($price_2) OR $price_2 == 0) {
      $price_2 = 999999;
    }
    if (empty($price_3) OR $price_3 == 0) {
      $price_3 = 999999;
    }
    return min($price_1, $price_2, $price_3);
  }
}

echo auditPrice("kru", 356, 56, 777);
