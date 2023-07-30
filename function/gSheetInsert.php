<?php
function gSheetInsert($elems, $client) {
    //Код записи данных в таблицу гугл шит
    $service = new Google_Service_Sheets($client);
    //id листа из урл
    $spreadsheetId = "1owRwWJm_SCt18Xi3cMkxaamGLmC1xokYsUEdyHjE94M";
    //Название вкладки листа
    $range = "sheet_1"; // Sheet name
    unset($newArr);
    $newArr[] = $elems;
    $body = new Google_Service_Sheets_ValueRange([
      'values' => $newArr
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
    /*
    if($result->updates->updatedRows == 1){
      return "Success";
    } else {
      return "Fail";
    }
    */
}

