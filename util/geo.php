<?php

// Returns user's location based on ip address

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
