<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('../getDB.php');

function gen_id($length) {
	$charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_+-')

	$str = '';
	$count = strlen($charset);
	while ($length--) {
		$str .= $charset[mt_rand(0, $count-1)];
	}

	return $str;
}

function idIsUsed($inID, $dbh) {
	// Assumes DBH is valid

	// Check if the key is already in the MySQL database
	$sth = $dbh->prepare('SELECT FROM keytable WHERE keyval=:key');
	$sth->execute(array(':requester'=>$inID));

	$row = $sth->fetch(PDO::FETCH_ASSOC);
	if( $row["keytable"] == null) {
		return false;
	}

	return true;
}

function logID($inID, $dbh) {
	// Assumes DBH is valid

	// Enter new key into the MySQL database
	$sth = $dbh->prepare('INSERT INTO keytable (keyval, timestamp) VALUES (:key, CURRENT_TIMESTAMP)');
	//$sth->execute(array(':requester'=>$requester, ':worker'=>$worker, ':hit'=>$hit, ':assignment'=>$assignment));
	$sth->execute(array(':requester'=>$inID));

}


// ========= MAIN ======= //


// Try to connect to the DB
try {
	// Use a shared connection file
	$dbh = getDatabaseHandle();
} catch(PDOException $e) {
	echo $e->getMessage();
}


// If the DB connection was made correctly...
if($dbh) {
	$key = gen_id(15);

	while( idIsUsed($key, $dbh) ) {
		// Find a new key
		$key = gen_id(15);
	}

	// Log the new key
	log_id($key, $dbh);

	echo($key);
}
else {
	echo("No DB handle!");
}

?>
