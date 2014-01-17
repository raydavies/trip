<?php
require_once('models/model.php');

class Location extends Model {
	public $locations;

	public function get_site_cities(){
		$query = "SELECT c.city_id, c.city, c.state 
					FROM ".$this->global_db.".cities AS c 
					JOIN ".$this->global_db.".sites_cities AS sc 
					ON c.city_id = sc.city_id 
					WHERE sc.site_id = ".$this->site_id." 
					ORDER BY sc.sort ASC";
		$result = $this->db->query($query);
		if ($rows = $result->num_rows)
		{	
			$cities = array();
			for ($i=0;$i<$rows;$i++){
				$row = $result->fetch_assoc();
				$this->locations[$row['city_id']] = array($row['city_id'], $row['city']);
				$cities[$row['city_id']] = array('city'=>$row['city'],
													'state'=>$row['state']);
			}
			$result->free_result();
			return $cities;
		}
		return false;
	}
	
	public function get_city_by_id($id){

		$query = "SELECT city, state FROM cities 
					WHERE city_id = ".$id." LIMIT 1";
		$result = $this->db->query($query);
		$rows = $result->num_rows;
		if ($rows){
			$row = $result->fetch_assoc();
			$city = $row['city'];
		}
		$result->free_result();
		return $city;
	}
}
?>
