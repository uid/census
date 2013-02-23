<?php

function getDatabaseHandle() {
  // Uncomment to use the ROC DB
  //$dbh = new PDO("mysql:host=localhost;dbname=gtl", "root", "borkborkbork");

  // Uncomment to use the MSR sipsvc Azure DB
  $dbh = new PDO("mysql:host=us-cdbr-azure-east-a.cloudapp.net;dbname=owdla1db", "bc3f8638cf37ab", "ebe637f9");

  // Azure SQL instance
//  $dbh = new PDO ( "sqlsrv:server = tcp:h8fhn1cobb.database.windows.net,1433; Database = owdl-db", "owdl-admin", "tpar$566");

  return $dbh;
}

?>
