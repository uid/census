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
echo serialize($_SERVER);
// echo http_get_request_headers();
	// If the DB connection was made correctly...
	if($dbh) {
		$sth = $dbh->prepare ("SELECT tasks.id,content FROM tasks LEFT OUTER JOIN requests ON tasks.id=taskid AND workerid=:worker AND hitid=:hit ORDER BY RAND() LIMIT 1");
		$sth->execute(array(':worker'=>$worker, ':hit'=>$hit));
		$rows = $sth->fetch(PDO::FETCH_ASSOC);
		$rows = $sth->fetchAll();
		if( $rows[0] != 1 ) {
			$data = array(
		  		"success"=>false,
		  		"summary"=>"",
		  		"data"=>"no task available"
			);
		} else {
			$data = array(
		  		"success"=>true,
		  		"summary"=>$row["summary"],
		  		"data"=>$row["content"]
			);

			$sth = $conn->prepare('INSERT INTO requests (requesterid, workerid, hitid, ip, mac, data, browser, taskid) VALUES (:requester, :worker, :hit, :ip, "", :data, "", :assignment)');
			$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':ip'=>$_SERVER['REMOTE_ADDR'], 
				':data'=>serialize($_SERVER), ':assignment'=>$data['id']));
		}
		echo $_GET['callback'] . '('.json_encode($data).')';		
	}
}
?>
