<?php

class WeatherController {

	public $weather;

	public function __construct($city,$state){
		$city = strtolower(str_replace(' ', '_', $city));
		$state = strtolower($state);
		$json = file_get_contents('http://api.wunderground.com/api/a11cca9ee4fee3a0/forecast/conditions/alerts/q/'.$state.'/'.$city.'.json');

		$json = json_decode($json,true);
		if (!empty($json['response']['error']))
		{
			throw new Exception($json['response']['error']['description']);
		}

		$date = date_create($json['current_observation']['local_time_rfc822']);
		$weather = '';
		$weather .= "<div id='weather_wrapper'>";
		$weather .= date_format($date,'l, F j')."<br>";
		$weather .= date_format($date,'g:ia')." ".$json['current_observation']['local_tz_short']."<br>";
		$weather .= "<img src='".$json['current_observation']['icon_url']."'><br>";
		$weather .= $json['current_observation']['weather']."&nbsp;";
		$weather .= $json['current_observation']['temp_f']."&deg;F<br>";
		$weather .= "Today: ".$json['forecast']['simpleforecast']['forecastday'][0]['high']['fahrenheit']."&deg;F High ".$json['forecast']['simpleforecast']['forecastday'][0]['low']['fahrenheit']."&deg;F Low<br>";
		$weather .= "Tomorrow: ".$json['forecast']['simpleforecast']['forecastday'][1]['high']['fahrenheit']."&deg;F High ".$json['forecast']['simpleforecast']['forecastday'][1]['low']['fahrenheit']."&deg;F Low";

		if (!empty($json['alerts'])){
			foreach($json['alerts'] as $alert){
				$weather .= "<br>".$alert['description']." until ".date_format(date_create($alert['expires']),'g:ia e');
			}
		}
		$weather .= "</div>";

		$this->weather = $weather;
	}
}
?>
