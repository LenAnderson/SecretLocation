<?php
$config = json_decode(file_get_contents('config.json'));

if ($_REQUEST['key'] == $config->writeKey) {
	$lat = $_REQUEST['lat'];
	$lon = $_REQUEST['lon'];
	if (preg_match('/^-?\d+(\.\d+)?$/', $lat) && preg_match('/^-?\d+(\.\d+)?$/', $lon)) {
		$lat -= $config->nullIsland->lat;
		$lon -= $config->nullIsland->lon;
		$locations = json_decode(file_get_contents('locations.json') ?? '[]');
		$locations[] = [
			'timestamp' => time(),
			'lat' => $lat,
			'lon' => $lon
		];
		if (count($locations) > $config->keep) {
			$locations = array_slice($locations, -$config->keep);
		}
		file_put_contents('locations.json', json_encode($locations));
		echo 'OK '.count($locations);
	} else {
		echo 'nope';
	}
} else {
	echo 'wrong key';
	http_response_code(403);
}