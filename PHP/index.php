<?php

	function getWeather($zipcode, $api) {
		if (false === ($weather = @file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=$zipcode$api"))) {
			return array( 'success' => 'Failed', 
						  'message' => 'Zipcode not found.' );
		}
		else {
			$weather = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?zip=$zipcode$api"));
			$weather = array( 'description' => $weather->weather[0]->description,
							  'temp'        => $weather->main->temp,
							  'humidity'    => $weather->main->humidity,
							  'wind'        => $weather->wind->speed,
							  'name'        => $weather->name );
			return $weather;
		}
	}

	$zipcode = isset($_GET['zipcode']) ? $_GET['zipcode'] : NULL;
	$api = '&appid=d597693a03609500878eeed5636c671a';

	header('Content-Type: application/json');
	print_r(json_encode(getWeather($zipcode, $api)));

?>