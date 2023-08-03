<?php
function auditPrice($price_1, $price_2 = 999999, $price_3 = 999999) {
    if ($price_1 == NULL) AND $price_2 == NULL AND $price_3 == NULL) {
      return "error";
    } else {
      if ($price_1 == NULL OR $price_1 == 0) {
        $price_1 = 999999;
      }
      if ($price_2 == NULL OR $price_2 == 0) {
        $price_2 = 999999;
      }
      if ($price_3 == NULL OR $price_3 == 0) {
        $price_3 = 999999;
      }
      return min($price_1, $price_2, $price_3);
    }
  }