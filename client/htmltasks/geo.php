
<html>
<head></head>
<body>
  <br>
  <br>
  <br>
  <center>
  <font color='steelblue'>

<?php

/////////////////////////////////////////////////////////////
// In C terms, our "main"
//

//$ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$ip = $_SERVER['REMOTE_ADDR'];
echo "Either your ip <b>or</b> the ip of the closest proxy server to me is:<br><br>
 <font size='+1'>" . $ip . "</font><br><br>
 <img src='http://auroramag.files.wordpress.com/2011/12/thumb-up-for-2012-copy.jpg?w=150&h=138'>
 <br>
 <br>
 <br>
 <br>";

echo "Now I am going to try to figure out where that is...<br><br><font size='+1'>";

print_r(geoCheckIP($ip));

function geoCheckIP($ip)
{
	//check, if the provided ip is valid
	if(!filter_var($ip, FILTER_VALIDATE_IP))
	{
	  throw new InvalidArgumentException("IP is not valid");
	}

	//contact ip-server
	$response=@file_get_contents('http://www.freegeoip.net/json/'.$ip);

	if (empty($response))
	{
	  throw new InvalidArgumentException("Error contacting Geo-IP-Server");
	}

	return $response;
}
?>

    </font>
  </center>
</body>
</html>