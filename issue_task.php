<?php
header('content-type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');


// Make sure a session is defined
if( isset($_REQUEST['workerId']) && isset($_REQUEST['assignmentId']) && isset($_REQUEST['hitId']) && isset($_REQUEST['requesterId'])  ) {
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
		$sth = $dbh->prepare ("SELECT tasks.id,tasks.content FROM tasks LEFT OUTER JOIN requests ON tasks.id=taskid AND workerid=:worker AND hitid=:hit ORDER BY RAND() LIMIT 1");
		$sth->execute(array(':worker'=>$worker, ':hit'=>$hit));
		if ($sth->rowCount() != 1){
			$data = "no task available";
		} else {
			$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);			
			$data = $row["content"];
		}
		echo $_GET['callback'] . '('.json_encode($data).')';		
	}
}
?>
