<?php
function curlFunc($url) {
    //Пауза для неравномерных запросов
    sleep(rand(1, 10));
    $curl = curl_init();
    // Указываем адрес страницы:
    curl_setopt($curl, CURLOPT_URL, $url);
    //сохранять в переменную
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //протокол HTTPS
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //cookie
    //Имя и путь к файлу
    preg_match('#https://([a-z.-]+)#', $url, $matches);
    $name = preg_replace('#\.#', "_", $matches[1]).".txt";
    $path = '/temp/'.$name;
    $cookieFilePath = $_SERVER['DOCUMENT_ROOT'] . $path;
    //echo $cookieFilePath;
    curl_setopt($curl, CURLOPT_COOKIEFILE, $cookieFilePath);
    curl_setopt($curl, CURLOPT_COOKIEJAR,  $cookieFilePath);
    //заголовкb USERAGENT
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36');
    // Выполняем запрос, сохранив ответ в переменную:
    $res = curl_exec($curl);
    return $res;
}
