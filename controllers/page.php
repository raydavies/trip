<?php
include_once(BASEPATH.'/models/pagemodel.php');
ob_start();
if (!empty($segments[2]))
{
	$path = $_SERVER['DOCUMENT_ROOT'].'/trip';
	if (strpos($segments[2], '-') !== false)
	{
		$location = explode('-', $segments[2]);
		$city = $location[0];

		if (strpos($city, '_') !== false)
		{
			$city = str_replace('_', ' ', $city);
		}
		$params['current_city'] = ucwords($city);
		$params['current_state'] = strtoupper($location[1]);
	}
	elseif ($segments[2] == 'admin')
	{
		$params['flag_admin'] = 1;
	}

	for ($i=1; $i<count($segments) ; $i++)
	{
		if ($i == 1)
		{
			continue;
		}
		if (!empty($segments[$i]))
		{
			$path .= "/".$segments[$i];
		}
	}
	//echo $path;
	if (file_exists($path.".php"))
	{
		$params['pathname'] = $path.".php";
	}
	else
	{
		$params['pathname'] = $path."/front.php";
	}
	if (isset($query))
	{
		$params['query_string'] = $query;
	}
}
else
{
	$params['pathname'] = $_SERVER['DOCUMENT_ROOT']."/trip/front.php";
}

$page = new Page($params);
if (is_file(APPPATH.'/'.$segments[2].'.php'))
{
	$class = $segments[2];
	include_once(APPPATH.'/'.$class.'.php');
}
if (!empty($segments[3]) && $segments[3] != 'login')
{
	$_SESSION['redirect'] = $_SESSION['http_referer'];
}
if (!isset($params['current_city'], $params['current_city']))
{
	$folder = '';
	if (empty($params['flag_admin']))
	{
		//array_shift($segments);
		//$folder = 'admin/';
		if (empty($segments[2]))
		{
			if (is_file(APPPATH.'/'.$folder.'front.php'))
			{
				include_once(APPPATH.'/'.$folder.'front.php');
			}
			else
			{
				include_once(VIEWPATH.'/404.php');
			}
		}
		else if (is_file(APPPATH.'/'.$folder.$segments[2].'.php'))
		{
			if ($segments[2] != 'front')
			{
				include_once(APPPATH.'/'.$folder.$segments[2].'.php');
			}
		}
		else
		{
			include_once(VIEWPATH.'/404.php');
		}
	}
}
else
{
	include_once(BASEPATH.'/models/weathermodel.php');
	include_once(BASEPATH.'/models/locationmodel.php');
	include_once(BASEPATH.'/models/destinationmodel.php');
	include_once(BASEPATH.'/models/itinerarymodel.php');

	$page->city = $params['current_city'];
	$page->state = $params['current_state'];
	try
	{
		$forecast = new WeatherController($page->city, $page->state);
		$page->weather = $forecast->weather;
	}
	catch (Exception $e)
	{
		header("Location: /".$page->site_url."/404/");
		die;
	}
	$page->destinations = $page->get_destinations();

	$itinerary = new Itinerary;
	$page->itinerary = $itinerary->get_itinerary($page->city);

	$location = new Location;
	$page->cities = $location->get_site_cities();

	$destination = new Destination($page->city);
	$page->locations = $destination->locations;
	$page->markers = $destination->grab_markers();

	include_once(VIEWPATH.'/city.php');
}
?>
