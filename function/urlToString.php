<?php
function urlToString($url) {
    preg_match('#https://([a-z.-]+)#', $url, $matches);
    $name = preg_replace('#\.#', "_", $matches[1]).".txt";
    return '/temp/'.$name;
}
?>