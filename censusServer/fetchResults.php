<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');

// Make sure a session is defined
if( isset($_REQUEST['hitId']) ) {

	$hitId = $_REQUEST['hitId'];

	// Try to connect to the DB
	try {
		$dbh = getDatabaseHandle();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}


	// If the DB connection was made correctly...
	if($dbh) {
		$sth = $dbh->prepare ("SELECT id,workerId FROM requests WHERE hitId=:hitId");
		$sth->execute(array(':hitId'=>$hitId));
		while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
			$retStr = hash("md5", $row["workerId"]) . "," . $row["id"];

			$sth2 = $dbh->prepare ("SELECT value FROM responses WHERE requestid=:id");
			$sth2->execute(array(':id'=>$row["id"]));
			$row2 = $sth2->fetch(PDO::FETCH_ASSOC);
			$retStr = $retStr . "," . $row2["value"] . "\n\r";

			echo($retStr);
		}
	}
}
?>
