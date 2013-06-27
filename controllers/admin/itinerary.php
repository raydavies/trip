<?php
$sql = 'SELECT c.city_id, c.city AS name FROM '.$page->global_db.'.cities AS c 
		JOIN '.$page->global_db.'.sites_cities AS sc 
		ON sc.city_id = c.city_id 
		WHERE sc.site_id = '.$page->site_id;
$result = $page->db->query($sql);
if ($result && $result->num_rows)
{
	$city_opts = array();
	while ($row = $result->fetch_assoc())
	{
		$city_opts[$row['city_id']] = array('city_id'=>$row['city_id'],'name'=>$row['name']);
	}
	$result->free_result();
}
include_once(VIEWPATH.'/admin/itinerary.php');
?>
