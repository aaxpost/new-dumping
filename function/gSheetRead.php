<?php
function gSheetRead() {
    //Получаем данные со страницы гугл лист
    //Для этого разбираем ссылку регулярными выражениями
    $href = 'https://docs.google.com/spreadsheets/d/1ByccFLnRlHkoZeWtoVum3fFzWU5LC1Lk87o5ZaC2w2c/edit#gid=756920771';
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


