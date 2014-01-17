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
		$additions = $_POST['add'];
		if (isset($_POST['confirm']))
		{
			$confirm = $_POST['confirm'];
		}
	}

	if (empty($additions))
	{
		$page->title = 'Error!';
		$title = 'Request Error!';
		$info = array('There was an error in submitting your request. Please click the link below to go back and try again.');
		$links = array();
		$links[] = array('url'=>'../../view_all_destinations/','title'=>'Back to Destinations List');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	elseif (empty($confirm))
	{
		$page->title = 'Confirmation';
		$title = 'Destination Summary';
		
		$query = "SELECT destination_name 
				FROM ".$page->global_db.".destinations 
				WHERE destination_id IN (".implode(',', $additions).")";
		$result = $page->db->query($query);
		if ($result && $result->num_rows)
		{
			$info = array();
			while ($row = $result->fetch_assoc())
			{
				$info[] = $row['destination_name'];
			}
			$result->free_result();
		}

		$form = 'add';
		$links[] = array('url'=>'view_all_destinations/','title'=>'Back to Destinations List');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	else {
		$delimiter = '), ('.$page->site_id.',';
		$sql = "(".$page->site_id.",".implode($delimiter, $additions).")";
		$query = "INSERT INTO ".$page->global_db.".sites_destinations(site_id, destination_id) VALUES ".$sql;

		$result = $page->db->query($query);
		if ($result) {
			$page->title = 'Success!';
			$title = 'Successfully Added Destination(s)!';
			$links[] = array('url'=>'view_all_destinations/','title'=>'Back to Destinations List');
			$links[] = array('url'=>'view_destination/','title'=>'View Itinerary Destinations');
			$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
		}
		else
		{
			$page->title = 'Error!';
			$title = 'Request Error!';
			$info = array('There was an error in submitting your request. Please click the link below to go back and try again.');
			$links = array();
			$links[] = array('url'=>'../../view_all_destinations/','title'=>'Back to Destinations List');
			$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
		}
	}
	include_once(VIEWPATH.'/admin/add_handler.php');
}
else {
	header("Location: login/");
	die;
}
?>
