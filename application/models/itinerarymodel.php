<?php
require_once('models/model.php');
class Itinerary extends Model {
	public $planner;

	public function __construct(){
		parent::__construct();
	}

	public function get_itinerary($city=NULL)
	{
		if (isset($city))
		{
			$where = " AND c.city = '".strtolower($city)."'";
		}
		else
		{
			$where = '';
		}
		$query = "SELECT i.datetime, i.details, c.city, c.state 
					FROM ".$this->site_db.".itinerary AS i, 
					".$this->global_db.".cities AS c 
					WHERE c.city_id=i.city_id".$where." 
					ORDER BY i.datetime ASC";
		$result = $this->db->query($query);
		if ($result && $result->num_rows)
		{	
			$planner = array();
			while ($row = $result->fetch_assoc()){
				$date = date_format(date_create($row['datetime']), 'F j');
				$planner[] = array('datetime'=>$row['datetime'],
								   'date'=>$date, 
								   'city'=>$row['city'], 
								   'state'=>$row['state'], 
								   'details'=>$row['details']);
			}
			$result->free_result();
			return $planner;
		}
		return null;
	}
}
?>
