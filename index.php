<html>
  <head>
    <title>NEW-DUMPING</title>
  </head>
  <body>
    <h1>NEW-DUMPING</h1>
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

//Считываю данные для парсинга из базового листа
$array = gSheetRead();
//Подготовка объекта для записи данных в лист
require __DIR__ . '/vendor/autoload.php';
$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

//Первая строка, дата запроса и фамилия менеджера
gSheetInsert([date(DATE_RFC822), 'Назаренко'], $client);

foreach ($array as $key => $elems) {
  if ($key == 0) {
    //1 ROW Строка с артикулом и именем партнера или ссылкой на сайт
    //gSheetInsert($elems, $client);
  }

  if ($key != 0) {
    //KRUCHKOV
    $url = $elems[1];
    //echo $url;exit;
    var_dump(curlFunc($url));exit;
    $document = new Document(curlFunc($url), true);
    //Регулярная цена на нашем сайте
    $price = $document->first('h2.h2_price');
    $price = $price->text();
    //echo $price;exit;
    if (empty($price)) {
      $elems[1] = 'error';
    } else {
      preg_match('/[0-9\s]+/', $price, $matches);
      $string = intval(str_replace(" ", "", $matches[0]));
      $elems[1] = intval($string);
      //$elems[1] = $price->text();
      //$elems[1] = 1000;
      //PARTNER
      $elems[2] = 2000;
    }
  }
  gSheetInsert($elems, $client);
}
/*
// [START sheets_conditional_formatting]
use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets\BatchUpdateSpreadsheetRequest;
use Google\Service\Sheets\Request;

function conditionalFormatting($spreadsheetId)
    {
        /* Load pre-authorized user credentials from the environment.
           TODO(developer) - See https://developers.google.com/identity for
            guides on implementing OAuth2 for your application. */
/*
        
        $client = new Google\Client();
        $client->setAuthConfig(__DIR__ . '/credentials.json');
        $client->setApplicationName('Google Sheets with Primo');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        
        $service = new Google_Service_Sheets($client);

        try{
            $myRange = [
                'sheetId' => 0,
                'startRowIndex' => 0,
                'endRowIndex' => 3,
                'startColumnIndex' => 0,
                'endColumnIndex' => 3,
            ];
            //execute the request
            $requests = [
                new Google_Service_Sheets_Request([
                'addConditionalFormatRule' => [
                    'rule' => [
                        'ranges' => [ $myRange ],
                        'booleanRule' => [
                            'condition' => [
                                'type' => 'CUSTOM_FORMULA',
                                'values' => [ [ 'userEnteredValue' => '=GT($B3,$C3)' ] ]
                            ],
                            'format' => [
                                'textFormat' => [ 'foregroundColor' => [ 'red' => 0.8 ] ]
                                ]
                                ]
                            ],
                            'index' => 0
                            ]
                        ])
                        
        ];
        
        $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest([
            'requests' => $requests
        ]);
        $response = $service->spreadsheets->batchUpdate($spreadsheetId, $batchUpdateRequest);
        printf("%d cells updated.", count($response->getReplies()));
        return $response;
    }
    catch(Exception $e) {
        // TODO(developer) - handle error appropriately
        echo 'Message: ' .$e->getMessage();
    }
}
    // [END sheets_conditional_formatting]
    require 'vendor/autoload.php';
    conditionalFormatting('1owRwWJm_SCt18Xi3cMkxaamGLmC1xokYsUEdyHjE94M');

*/




