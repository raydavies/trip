<?php
if (!isset($_SESSION))
{
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
ob_flush();

if (isset($_SESSION['username']))
{
	$query = "SELECT d.destination_id, d.location_id, d.destination_name, d.url, d.tags, c.city 
				FROM ".$page->global_db.".sites_destinations AS sd 
				JOIN ".$page->global_db.".destinations AS d 
				ON d.destination_id=sd.destination_id 
				JOIN ".$page->global_db.".destinations_cities AS dc 
				ON d.destination_id=dc.destination_id 
				JOIN ".$page->global_db.".cities AS c 
				ON c.city_id=dc.city_id 
				WHERE sd.site_id = ".$page->site_id." ORDER BY city";

	$result = $page->db->query($query);
	if ($result && $result->num_rows)
	{
		$places = array();
		while ($row = $result->fetch_assoc())
		{
			foreach ($row as $key=>$value)
			{
				$places[$row['destination_id']][$key] = $value;
			}
		}
		$result->free_result();
	}
	include_once(VIEWPATH.'/admin/view_destination.php');
}
else {
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>
