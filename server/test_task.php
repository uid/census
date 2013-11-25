<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');
?>

<html>
<head>
  <script src="http://code.jquery.com/jquery-latest.min.js"
        type="text/javascript"></script>
</head>
<body>
<form id='censusForm' name='censusForm'>
<!------- start here -->

<?php

	// Try to connect to the DB
	try {
		$dbh = getDatabaseHandle();
	} catch(PDOException $e) {
		echo $e->getMessage();
	}


	// If the DB connection was made correctly...
	if($dbh) {
		$sth = $dbh->prepare ("SELECT id,summary FROM `tasks` ORDER BY RAND()");
		$sth->execute();
		$row = $sth->fetch(PDO::FETCH_ASSOC);

		if( $row['id'] == null ) {
			print("Error finding task");
		} else {
			// load the source file
			$content = file_get_contents('tasks/' . $row["summary"] . '.html');
			print($content);
		}
	}
?>

<!------- end here -->
<input type="submit" />
</form>
</body>