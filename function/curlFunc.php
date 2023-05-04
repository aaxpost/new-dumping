<?php
function ($url) {
    //Нужно добавить автоматизацию имени файла по урл и сохранение в папке темп. 

    $curl = curl_init();
    // Указываем адрес страницы:
    $url = 'https://kruchkov.com.ua/';
    // Указываем адрес страницы:
    curl_setopt($curl, CURLOPT_URL, $url);
    //сохранять в переменную
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //протокол HTTPS
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //cookie
    $cookieFilePath = $_SERVER['DOCUMENT_ROOT'] . '/cookie.txt';
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFilePath);
    curl_setopt($curl, CURLOPT_COOKIEJAR,  $cookieFilePath);
    //заголовка USERAGENT
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
    // Выполняем запрос, сохранив ответ в переменную:
    $res = curl_exec($curl);
    return $res;
}
