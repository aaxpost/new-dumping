<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

echo "test sheet";

require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('Google Sheets with Primo');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
//id листа из урл
$spreadsheetId = "1owRwWJm_SCt18Xi3cMkxaamGLmC1xokYsUEdyHjE94M";
//Название вкладки листа
$range = "sheet_1"; // Sheet name
//Массив, который вставится в строку таблицы
$values = [
	['this is data to insert1', 'my name'], ['this is data to insert2', 'my name'],
];
//echo "<pre>";print_r($values);echo "</pre>";exit;
$body = new Google_Service_Sheets_ValueRange([
	'values' => $values
]);
$params = [
	'valueInputOption' => 'RAW'
];

$result = $service->spreadsheets_values->append(
	$spreadsheetId,
	$range,
	$body,
	$params
);

if($result->updates->updatedRows == 2){
	echo "Success";
} else {
	echo "Fail";
}