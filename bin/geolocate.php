<?php
function lookup_latlng()
{
	@$link = mysqli_connect('localhost','mumbles_jordan','icedm1lk','mumbles_trip') or die("Could not connect (".mysqli_connect_errno()."): ".mysqli_connect_error());
	$query = "SELECT * FROM locations";
	@$result = mysqli_query($link,$query) or die("MySQL error (".mysqli_errno($link)."): ".mysqli_error($link));
	$latlng = array();
	while ($row = $result->fetch_assoc())
	{
		if (empty($row['longitude']) || empty($row['latitude']))
		{
			sleep(2);
			$address = str_replace(' ', '+', $row['address']);
			$city = str_replace(' ', '+', $row['city']);
			$url = 'http://maps.googleapis.com/maps/api/geocode/json';
			$url .= '?address='.$address.'+'.$city.'+'.$row['state'].'&sensor=false';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$json = curl_exec($ch);
			curl_close($ch);
			$loc = json_decode($json, true);
			$lat = $loc['results'][0]['geometry']['location']['lat'];
			$lng = $loc['results'][0]['geometry']['location']['lng'];
			$latlng[] = array('id'=>$row['location_id'], 'lng'=>$lng, 'lat'=>$lat);
		}
	}
	$result->free_result();
	if (!empty($latlng))
	{
		foreach ($latlng as $l)
		{
			if (empty($l['lat']) || empty($l['lng']))
			{
				print_r($l);
				echo "<br>";
				continue;
			}
			$query = "UPDATE locations SET longitude = ".$l['lng'].", latitude = ".$l['lat']." WHERE location_id = ".$l['id'];
			@$result = mysqli_query($link,$query) or die("MySQL error (".mysqli_errno($link)."): ".mysqli_error($link));
		}
	}
	echo "Done";
}

lookup_latlng();
?>
