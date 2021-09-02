<?php
$config = json_decode(file_get_contents('config.json'));

if ($_REQUEST['key'] == $config->readKey) {
	if (is_file('locations.json')) {
		$locations = json_decode(file_get_contents('locations.json') ?? '[]');
	} else {
		$locations = [];
	}
} else {
	echo 'wrong key';
	return http_response_code(403);
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="js/lib/leaflet/leaflet.css">
	<link rel="stylesheet" href="css/location.css">
	<title>Location</title>
</head>
<body>
	<div id="controls">
		<div><input type="range" id="time"></div>
		<div id="timeValue"></div>
	</div>
	<div id="map" data-locations="<?=htmlspecialchars(json_encode($locations))?>" data-markers="<?=htmlspecialchars(json_encode($config->markers))?>"></div>

	<script src="js/location.js" type="module"></script>
</body>
</html>