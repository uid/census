<?php
header('content-type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');

// Find user's location
$ip = $_SERVER['REMOTE_ADDR'];
$response=@file_get_contents('http://www.freegeoip.net/json/'.$ip);
$locations=json_decode($response, true);
$country = $locations['country_name'];

$worker = $_GET['workerId'];
$hit = $_GET['hitId'];
$requester = $_GET['requesterId'];

// Make sure a session is defined
if( isset($_REQUEST['workerId']) && isset($_REQUEST['assignmentId']) && isset($_REQUEST['hitId']) && isset($_REQUEST['requesterId'])  ) {

	// Try to connect to the DB
	try {
		$dbh = getDatabaseHandle();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}


	// If the DB connection was made correctly...
	if($dbh) {
		$sth = $dbh->prepare ("SELECT tasks.id,summary,content FROM tasks LEFT OUTER JOIN requests ON tasks.id=taskid AND workerid=:worker AND hitid=:hit ORDER BY RAND() LIMIT 1");
		$sth->execute(array(':worker'=>$worker, ':hit'=>$hit));
			$row = $sth->fetch(PDO::FETCH_ASSOC);

		if( $row['id'] == null ) {
			$data = array(
		  		"success"=>false,
		  		"summary"=>"",
		  		"data"=>"no task available",
		  		"request_id"=>-1
			);
		} else {

			//	Enter data from user into the MySQL database
			$query = ('INSERT INTO requests (requesterid, workerid, hitid, ip, mac, data, browser, taskid, country) 
				VALUES (:requester, :worker, :hit, :ip, "", :data, "", :assignment, :country)');

			$sth = $dbh->prepare($query);

			$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':ip'=>$_SERVER['REMOTE_ADDR'],  
				':data'=>serialize($_SERVER), ':assignment'=>$row['id'], ':country'=>$country));

			$data = array(
		  		"success"=>true,
		  		"summary"=>$row["summary"],
		  		"data"=>$row["content"],
		  		"request_id"=>$dbh->lastInsertId()
			);
		}
		echo $_GET['callback'] . '('.json_encode($data).')';
	}
}
?>