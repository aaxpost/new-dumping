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
$href = 'https://romb.ua/ua/kartoplesadzhalka-lancjugova-premium-ks8.html';
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
          //echo "has";
          if (strlen($pattern_2 > 4)) {
              $price = $document->find($pattern_1)[0]->first($pattern_2)->text();
              //echo "1:".$price;
            } else {
              $price = $document->find($pattern_1)[0]->text();
              //echo "2:".$price;
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
//echo "2:".getPrice ($elems, $i, 'div.t-store__prod-popup__price-item.t-name.t-name_md');
$price_1 = getPrice ($elems, $i, 'div.price-box.price-final_price', 'span.price');
//$price_2 = getPrice ($elems, $i, 'span.autocalc-product-special');

echo auditPrice($price_1);

/*
// все ссылки
$document->find('a');

// любой элемент с id = "foo" и классом "bar"
$document->find('#foo.bar');

// любой элемент, у которого есть атрибут "name"
$document->find('[name]');

// эквивалентно
$document->find('*[name]');

// поле ввода с именем "foo"
$document->find('input[name=foo]');
$document->find('input[name=\'foo\']');
$document->find('input[name="foo"]');

// поле ввода с именем "foo" и значением "bar"
$document->find('input[name="foo"][value="bar"]');

// поле ввода, название которого НЕ равно "foo"
$document->find('input[name!="foo"]');

// любой элемент, у которого есть атрибут,
// начинающийся с "data-" и равный "foo"
$document->find('*[^data-=foo]');

// все ссылки, у которых адрес начинается с https
$document->find('a[href^=https]');

// все изображения с расширением png
$document->find('img[src$=png]');

// все ссылки, содержащие в своем адресе строку "example.com"
$document->find('a[href*=example.com]');

// все ссылки, содержащие в атрибуте data-foo значение bar отделенное пробелом
$document->find('a[data-foo~=bar]');

// текст всех ссылок с классом "foo" (массив строк)
$document->find('a.foo::text');

// эквивалентно
$document->find('a.foo::text()');

// адрес и текст подсказки всех полей с классом "bar"
$document->find('a.bar::attr(href|title)');

// все ссылки, которые являются прямыми потомками текущего элемента
$element->find('> a');

*/











        

        
        

      
   

    
