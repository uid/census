<?php
header('content-type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');

// Make sure a session is defined
if( isset($_REQUEST['requestId']) ) {
	$request = $_REQUEST['requestId'];

	// Try to connect to the DB
	try {
		$dbh = getDatabaseHandle();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}

	// If the DB connection was made correctly...
	if($dbh) {
		$sth = $dbh->prepare('INSERT INTO responses (requestid, response) VALUES (:requestid, :response)');
		//$sth->execute(array(':requestid'=>$request, ':response'=>file_get_contents('php://input')));
		$sth->execute(array(':requestid'=>$request, ':response'=>$_SERVER['QUERY_STRING']));

	  	if ($sth->rowCount() != 1)
			$data = array(
		  		"success"=>false
			);
	  	else {    
		    $data = array(
			 	"success"=>true
			);
	  }
		echo $_GET['callback'] . '('.json_encode($data).')';				
	}
}
?>
