<?php
//Убрал из 
function auditHref($href) {
    if (strlen($href) < 4) {
      return false;
    } else {
        return true;
    }
  }