<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Use a shared connection file
include('getDB.php');


// Make sure a session is defined
if( isset($_REQUEST['session']) && isset($_REQUEST['round'])  ) {
  $session = $_REQUEST['session'];
  $round = intval($_REQUEST['round']);


  $id = session_id();

  // Try to connect to the DB
  try {
    $dbh = getDatabaseHandle();
  } catch(PDOException $e) {
    echo $e->getMessage();
  }

  // If the DB connection was made correctly...
  if($dbh) {
    $sth = $dbh->prepare ("SELECT done, role, user, cUsers.id AS user_id, chat, time, round, c.id AS chat_id FROM cChats c, cSessions, cUsers WHERE cUsers.id = c.user_id AND cSessions.session = :session AND round <= :round AND cSessions.id = c.session_id AND c.id > :lastid ORDER BY time");
    $sth->execute(array(':session'=>$session, ':lastid'=>$lastid, ':round'=>$round));

    while( $row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT) ) {
	//
    }

    print "}";
  }
}
?>
