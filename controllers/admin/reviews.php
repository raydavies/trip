<?php
$selectstring = "<select id='destination_select' name='destination'>";
	$query = "SELECT c.city, d.destination_id, d.destination_name
	   			FROM ".$page->global_db.".sites_destinations AS sd 
				LEFT JOIN ".$page->global_db.".destinations AS d 
				ON d.destination_id = sd.destination_id 
				LEFT JOIN ".$page->global_db.".destinations_cities AS dc 
				ON dc.destination_id = d.destination_id 
				LEFT JOIN ".$page->global_db.".cities AS c 
				ON c.city_id = dc.city_id 
				LEFT JOIN ".$page->global_db.".sites_cities AS sc
				ON sc.city_id = c.city_id AND sc.site_id = sd.site_id
				WHERE sc.site_id=".$page->site_id;

	$result = $page->db->query($query);
	if ($result && $result->num_rows)
	{
		$cities = array();
		while ($row = $result->fetch_assoc())
		{
			$cities[$row['city']][] = array('id'=>$row['destination_id'], 'name'=>$row['destination_name']);
		}
		$result->free_result();
		foreach ($cities as $city=>$destination)
		{
			$selectstring .= "<optgroup label='".$city."'>";
			foreach ($destination as $d)
			{
				if (isset($_GET['id']) && ($_GET['id'] == $d['id'])){
					$selected = "  selected = 'selected'";
				}
				else {
					$selected = '';
				}
				$selectstring .= "<option value='".$d['id']."'".$selected.">".$d['name']."</option>";
			}
			$selectstring .= "</optgroup>";
		}
	}
	preg_match('/[0-9]+/',$_SERVER['QUERY_STRING'],$id);
	$selectstring .= "</select>";
include_once(VIEWPATH.'/admin/reviews.php');
?>
