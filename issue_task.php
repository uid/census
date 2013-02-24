<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');


// Make sure a session is defined
if( isset($_REQUEST['workerId']) && isset($_REQUEST['assignmentId']) && isset($_REQUEST['hitId'])&& isset($_REQUEST['requesterId'])  ) {
	$worker = $_REQUEST['workerId'];
	$assignment = $_REQUEST['assignmentId'];
	$hit = $_REQUEST['hitId'];
	$requester = $_REQUEST['requesterId'];


	// Try to connect to the DB
	try {
		$dbh = getDatabaseHandle();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}

	// If the DB connection was made correctly...
	if($dbh) {
		$sth = $dbh->prepare ("SELECT tasks.id,task, workerid,hitid,taskid FROM tasks LEFT OUT JOIN requests ON tasks.id=taskid WHERE xxxx ORDER BY RAND()");
		$sth->execute(array(':worker'=>$worker, ':hit'=>$hit));

		while( $row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) ) {
			//
		}

		print "}";
	}
}
?>
