<?php
function gSheetRead($href) {
    //Получаем данные со страницы гугл лист
    //Для этого разбираем ссылку регулярными выражениями
    $patterId = '#d\/(.+)\/.+gid\=([0-9]+)$#';
    preg_match($patterId, $href, $matches);
    $id = $matches[1];
    $gid = $matches[2];
    $csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
    $csv = explode("\r\n", $csv);
    $array = array_map('str_getcsv', $csv);
    //Блок вывода данных при отладке
    //echo '<pre>';echo var_export($array);echo '</pre>';exit;
    return $array;
} 


