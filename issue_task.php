<?php
header('content-type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');
include('geo.php');

//$ip = $_SERVER['REMOTE_ADDR'];
//$ip = 171.66.185.85;
//$response=@file_get_contents('http://www.freegeoip.net/json/'.$ip);
//$locations=json_decode($response, true);
//$geoinfo = $locations;
//$geoinfo = geoCheckIP($ip);
//$country = $geoinfo['country_name'];
$country = "United States";

$_REQUEST['workerId'] = "testWorker";
$_REQUEST['assignmentId'] = 9999;
$_REQUEST['hitId'] = 9999;
$_REQUEST['requesterId'] = 9999;


$output =   "workerId: " . (isset($_REQUEST['workerId']) ? $_REQUEST['workerId'] : " not set :(") . "\n" . 
			"assignmentId: " . (isset($_REQUEST['assignmentId']) ? $_REQUEST['assignmentId'] : " not set :(") . "\n" .
			"hitId: " . (isset($_REQUEST['hitId']) ? $_REQUEST['hitId'] : " not set :(") . "\n" .
			"requesterId: " . (isset($_REQUEST['requesterId']) ? $_REQUEST['requesterId'] : " not set :(") . "\n" ;

file_put_contents('request.txt', $output);

// Make sure a session is defined
if( isset($_REQUEST['workerId']) && isset($_REQUEST['assignmentId']) && isset($_REQUEST['hitId']) && isset($_REQUEST['requesterId'])  ) {
	$worker = $_REQUEST['workerId'];
	$assignment = $_REQUEST['assignmentId'];
	$hit = $_REQUEST['hitId'];
	$requester = $_REQUEST['requesterId'];
    $country = "US";


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

		file_put_contents('log.txt', 'hello');

		if( $row['id'] == null ) {
			$data = array(
		  		"success"=>false,
		  		"summary"=>"",
		  		"data"=>"no task available",
		  		"request_id"=>-1
			);
		} else {

			$query = ('INSERT INTO requests (requesterid, workerid, hitid, ip, mac, data, browser, taskid, country) 
				VALUES (:requester, :worker, :hit, :ip, "", :data, "", :assignment, "' . $country . '")');

			$sth = $dbh->prepare($query);

			file_put_contents("debug.txt", $query);

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
