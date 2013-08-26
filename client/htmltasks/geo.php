
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
$ip = '171.66.174.65';

echo "Either your ip <b>or</b> the ip of the closest proxy server to me is:<br><br>
 <font size='+1'>" . $ip . "</font><br><br>
 <img src='http://auroramag.files.wordpress.com/2011/12/thumb-up-for-2012-copy.jpg?w=150&h=138'>
 <br>
 <br>
 <br>
 <br>";

echo "Now I am going to try to figure out where that is...<br><br><font size='+1'>";

//print_r(geoCheckIP($ip));
$data = geoCheckIP($ip);
echo "<br />"."IP Address: ";
echo $data["ip"];
echo "<br />"."Country: ";
echo $data["country_name"];
echo "<br />"."Region Name: ";
echo $data["region_name"];
echo "<br />"."City: ";
echo $data["city"];
echo "<br />"."Zip Code: ";
echo $data["zipcode"];

function geoCheckIP($ip)
{
	//check, if the provided ip is valid
	if(!filter_var($ip, FILTER_VALIDATE_IP))
	{
	  throw new InvalidArgumentException("IP is not valid");
	}

	//contact ip-server
	$response=@file_get_contents('http://www.freegeoip.net/json/'.$ip);
	$locations=json_decode($response, true);

	if (empty($response))
	{
	  throw new InvalidArgumentException("Error contacting Geo-IP-Server");
	}

	  return $locations;
}
?>

    </font>
  </center>
</body>
</html>