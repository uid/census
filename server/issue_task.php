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


// Make sure a session is defined
if( isset($_REQUEST['workerId']) && isset($_REQUEST['assignmentId']) && isset($_REQUEST['hitId']) && isset($_REQUEST['requesterId'])  ) {
	$worker = $_REQUEST['workerId'];
	$hit = $_REQUEST['hitId'];
	$assignment = $_REQUEST['assignmentId'];
	$requester = $_REQUEST['requesterId'];

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
			if( !isset($_REQUEST["page"]) ) {
                        	$query = ('INSERT INTO requests (requesterid, workerid, hitid, assignmentid, ip, mac, data, browser, taskid, country, url) 
                        	        VALUES (:requester, :worker, :hit, :assignment, :ip, "", :data, "", :task, :country, :url)');

                        	$sth = $dbh->prepare($query);

                        	$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':assignment'=>$assignment, ':ip'=>$_SERVER['REMOTE_ADDR'],
                                	':data'=>serialize($_SERVER), ':task'=>$row['id'], ':country'=>$country, ':url'=>$_SERVER["HTTP_REFERER"]));
			}
			else {
				$page = $_GET['page'];
                        	$query = ('INSERT INTO requests (requesterid, workerid, hitid, assignmentid, ip, mac, data, browser, taskid, country, url, pagesource) 
                        	        VALUES (:requester, :worker, :hit, :assignment, :ip, "", :data, "", :task, :country, :url, :page)');
                        	$sth = $dbh->prepare($query);

                        	$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':assignment'=>$assignment, ':ip'=>$_SERVER['REMOTE_ADDR'],
                                	':data'=>serialize($_SERVER), ':task'=>$row['id'], ':country'=>$country, ':url'=>$_SERVER["HTTP_REFERER"], ':page'=>$page));
			}

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
