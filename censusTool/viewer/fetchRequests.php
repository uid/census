<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


	// Try to connect to the DB
	try {
		// Use a shared connection file
		$dbh = new PDO("sqlite:../logs/requests.db");
	} catch(PDOException $e) {
		echo $e->getMessage();
	}

	//echo( $requester . " | " . $worker . " | " . $hit . " | " . $assignment) . "\n"; 

	// If the DB connection was made correctly...
	if($dbh) {
		//	Enter data from user into the MySQL database
		$sth = $dbh->prepare('SELECT DISTINCT hitId FROM requests');
		$sth->execute();

		$isFirst = true;
		$retStr = "";
		while( $row = $sth->fetch(PDO::FETCH_ASSOC) ) {
			if( !$isFirst ) {
				$retStr = $retStr . ",";
			}
			else {
				$isFirst = false;
			}

			//echo($row['workerid'] . "," . $row["assignmentId"] . "," . $row["hitId"] . "\n\r");
			$retStr = $retStr . $row["hitId"];
		}

		echo($retStr);
	}
	else {
		echo("no db handle!");
	}
?>
