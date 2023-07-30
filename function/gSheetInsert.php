<?php
function gSheetInsert($elem) {
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