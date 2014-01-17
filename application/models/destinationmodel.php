<?php
require_once('./models/model.php');
class Destination extends Model {
	public $locations;

	public function __construct($city){
		parent::__construct();
		$this->locations = array();
		$query = "SELECT l.*, d.destination_name, d.destination_id, d.url, d.img_url 
					FROM ".$this->global_db.".locations AS l 
					INNER JOIN ".$this->global_db.".destinations AS d 
					ON d.location_id = l.location_id 
					JOIN ".$this->global_db.".sites_destinations AS sd 
					ON sd.destination_id = d.destination_id 
					JOIN ".$this->global_db.".destinations_cities AS dc 
					ON dc.destination_id = d.destination_id 
					JOIN ".$this->global_db.".cities AS c 
					ON c.city_id = dc.city_id 
					WHERE c.city = '".$city."'
					AND sd.site_id = ".$this->site_id;
		$result = $this->db->query($query);
		if ($rows = $result->num_rows){
			for ($i=0;$i<$rows;$i++){
				$row = $result->fetch_assoc();
				foreach ($row as $label=>$value){
					$this->locations[$row['location_id']][$label] = $value;
				}
			}
		}
		else {
			$this->locations = NULL;
		}
		$result->free_result();
	}

	public function grab_markers(){
		if (isset($this->locations)){
			$first = false;
			$x=0;
			$all_locations = array();
			foreach($this->locations as $location){
				$locations_arr[$x]['latitude'] = $location['latitude'];
				$locations_arr[$x]['longitude'] = $location['longitude'];
				$locations_arr[$x]['destination_name'] = $location['destination_name'];
				$locations_arr[$x]['destination_id'] = $location['destination_id'];
				$locations_arr[$x]['location_id'] = $location['location_id'];
				$locations_arr[$x]['address1'] = $location['address'];
				$locations_arr[$x]['address2'] = $location['city'] . ', '. $location['state'] . ' ' . $location['zip'];
				$locations_arr[$x]['url'] = $location['url'];
				$locations_arr[$x]['img_url'] = 'assets/img/venue/'.$location['img_url'];
				$all_locations['location'.$x] = $locations_arr[$x];
				$x++;
			}
			return json_encode($all_locations);
		}
	}
}
?>
