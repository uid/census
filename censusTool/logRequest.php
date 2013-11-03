<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


// Make sure a session is defined
if( isset($_REQUEST['workerId']) && isset($_REQUEST['assignmentId']) && isset($_REQUEST['hitId']) ) { //&& isset($_REQUEST['requesterId'])  ) {
	$worker = $_GET['workerId'];
	$hit = $_GET['hitId'];
	$assignment = $_GET['assignmentId'];
	$requester = $_GET['requesterId'];


	// Try to connect to the DB
	try {
		// Use a shared connection file
		$dbh = new PDO("sqlite:logs/requests.db");
	} catch(PDOException $e) {
		echo $e->getMessage();
	}


	// If the DB connection was made correctly...
	if($dbh) {
		echo($requester . " | " . $worker . " | " . $hit . " | " . $assignment) . ".\n"; 
		//	Enter data from user into the MySQL database
		$sth = $dbh->prepare('INSERT INTO requests (requesterid, workerid, hitid, assignmentid, timestamp) VALUES (:requester, :worker, :hit, :assignment, CURRENT_TIMESTAMP)');
		//$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':assignment'=>$assignment));
		$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':assignment'=>$assignment));

		echo("success:: ");
		print_r($dbh->errorInfo());
	}
	else {
		echo("no db handle!");
	}
}
?>
