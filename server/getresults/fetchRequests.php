<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('../getDB.php');

	// Try to connect to the DB
	try {
		// Use a shared connection file
		$dbh = getDatabaseHandle();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}


	// If the DB connection was made correctly...
	if($dbh) {
		$inKey = $_REQUEST["key"];
		$inPass = $_REQUEST["pwd"];

		//	Enter data from user into the MySQL database
		$sth = $dbh->prepare('SELECT COUNT(*) AS num FROM keytable WHERE keyval=:key AND privpass=:pass)');
		$sth->execute(array(':key'=>$inKey, ':pass'=>md5($inPass)));
		$row = $sth->fetch(PDO::FETCH_ASSOC);
//echo($row["num"] . " <<>> " . md5($inPass));
		if( $row["num"] == 0 ) {
			echo("Invalid-Password");
			return -1;
		}


		//	Enter data from user into the MySQL database
		$sth = $dbh->prepare('SELECT * FROM responses WHERE requestid IN (SELECT id FROM requests WHERE authkey IS :key)');
		$sth->execute(array(':key'=>$inKey));


		$retStr = "";
		while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
			$retStr = $retStr . $row["value"] . "," . $row["timestamp"] . "\n";

		}

		echo($retStr);
	}
	else {
		echo("no db handle!");
	}
?>
