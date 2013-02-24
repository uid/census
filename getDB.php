<?php

function getDatabaseHandle() {
	$dbh = new PDO("mysql:host=localhost;dbname=census", "census_user", "censusss");
	return $dbh;
}

?>
