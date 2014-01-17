<?php
if (!isset($_SESSION))
{
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
ob_flush();

if (isset($_SESSION['username']))
{
	$destinations = $page->db->query("SELECT destination_id FROM ".$page->global_db.".sites_destinations WHERE site_id = ".$page->site_id);
	if ($destinations && $destinations->num_rows)
	{
		$dest = array();
		while ($d = $destinations->fetch_assoc())
		{
			$dest[] = $d['destination_id'];
		}
	}
	$destinations->free_result();
	$query = "SELECT d.destination_id, d.location_id, d.destination_name, d.url, d.tags, c.city 
				FROM ".$page->global_db.".destinations AS d 
				JOIN ".$page->global_db.".destinations_cities AS dc 
				ON d.destination_id=dc.destination_id 
				JOIN ".$page->global_db.".cities AS c 
				ON c.city_id=dc.city_id 
				JOIN ".$page->global_db.".sites_cities AS sc
				ON sc.city_id = c.city_id
				WHERE sc.site_id = ".$page->site_id." AND d.destination_id NOT IN (".implode(',', $dest).") ORDER BY city";

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
	include_once(VIEWPATH.'/admin/view_all_destinations.php');
}
else
{
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>
