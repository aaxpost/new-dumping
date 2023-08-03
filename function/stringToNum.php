<?php
function stringToNum ($string) {
    //$string = $string;
    $string = preg_replace('/\s+/', '', $string);
    $string=str_replace(",",'.',$string);
    $string=preg_replace("/[^x\d|*\.]/","",$string);
    settype($string, "integer");
    return $string;
}