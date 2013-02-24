<?php

function getDatabaseHandle() {
  // Use the ROC DB
  //$dbh = new PDO("mysql:host=localhost;dbname=census", "root", "borkborkbork");
	$dbh = new PDO("mysql:host=localhost;dbname=census", "census_user", "1234");

  return $dbh;
}

?>
