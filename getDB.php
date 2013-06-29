<?php

function getDatabaseHandle() {
  // Use the ROC DB
  $dbh = new PDO("mysql:host=localhost;dbname=census", "census", "censusss");

   return $dbh;
}

?>
