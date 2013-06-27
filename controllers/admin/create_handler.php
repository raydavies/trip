<?php
if (!isset($_SESSION))
{
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
ob_flush();

if (isset($_SESSION['username']))
{
	if (!empty($_POST))
	{
		$name = trim($_POST['name']);
		$url = trim($_POST['url']);
		$address = trim($_POST['address']);
		$city = trim($_POST['city']);
		$state = trim($_POST['state']);
		$zip = $_POST['zipcode'] === '' ? null : trim($_POST['zipcode']);
		$longitude = $_POST['longitude'] === '' ? null : trim($_POST['longitude']);
		$latitude = $_POST['latitude'] === '' ? null : trim($_POST['latitude']);
		
		$tags = null;

		if (!empty($_POST['tags']))
		{
			$tags = implode('/', $_POST['tags']);
		}

		if ($latitude && $longitude && $zip)
		{
			$query = "INSERT INTO ".$page->global_db.".locations(address,city,state,zip,longitude,latitude) 
						VALUES ('".$page->db->real_escape_string($address)."',
						'".$page->db->real_escape_string($city)."',
						'".$page->db->real_escape_string($state)."',
						'".$page->db->real_escape_string($zip)."',
						'".$longitude."','".$latitude."')";			
		}
		else
		{
			$query = "INSERT INTO ".$page->global_db.".locations(address,city,state) 
						VALUES ('".$page->db->real_escape_string($address)."',
						'".$page->db->real_escape_string($city)."',
						'".$page->db->real_escape_string($state)."')";
		}
		$result = $page->db->query($query);
		if ($result)
		{
			$location = $page->db->insert_id;
			$query = "INSERT INTO ".$page->global_db.".destinations(location_id, destination_name,url,tags) 
						VALUES ('".$page->db->real_escape_string($location)."',
						'".$page->db->real_escape_string($name)."',
						'".$page->db->real_escape_string($url)."',
						'".$tags."')";

			$result = $page->db->query($query);
			$destination = $page->db->insert_id;
			$query = "SELECT city_id FROM ".$page->global_db.".cities WHERE city LIKE '%".$city."%' LIMIT 1";
			$result = $page->db->query($query);
			if ($result)
			{
				$row = $result->fetch_assoc();
				$query = "INSERT INTO ".$page->global_db.".destinations_cities VALUES ('".$destination."','".$row['city_id']."')";
				$result = $page->db->query($query);
			}
			
			$page->title = 'Create Destination Success';
			$title = 'Successfully created destination!';
			$links = array();
			$links[] = array('url'=>'../create_destination/', 'title'=>'Add More?');
			$links[] = array('url'=>'../reviews/?id='.$destination, 'title'=>'Add a review for '.$name);
			$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
		}
		else
		{
			$page->title = 'Create Destination Error';
			$title = 'Error! Destination was not created!';
			$links = array();
			$links[] = array('url'=>'../create_destination/', 'title'=>'Try again?');
			$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
		}
	}
	else
	{
		$page->title = 'Create Destination Error';
		$title = 'Error! Destination was not created!';
		$links = array();
		$links[] = array('url'=>'../create_destination/', 'title'=>'Try again?');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	include_once(VIEWPATH.'/admin/create_handler.php');
}
else
{
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>
