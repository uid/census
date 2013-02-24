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
		$sth = $dbh->prepare ("SELECT tasks.id,content FROM tasks LEFT OUTER JOIN requests ON tasks.id=taskid AND workerid=:worker AND hitid=:hit ORDER BY RAND() LIMIT 1");
		$sth->execute(array(':worker'=>$worker, ':hit'=>$hit));
		$rows = $sth->fetch(PDO::FETCH_NUM);
		if( $rows[0] != 1 ) {
			$data = array(
		  		"success"=>false,
		  		"data"=>"no task available"
			);
		} else {
			$sth->execute(array(':worker'=>$worker, ':hit'=>$hit));
			$row = $sth->fetch(PDO::FETCH_ASSOC);
			$data = array(
		  		"success"=>true,
		  		"data"=>$row["content"]
			);
		}
		echo $_GET['callback'] . '('.json_encode($data).')';		
	}
}
?>
