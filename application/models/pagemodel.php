<?php
require_once('./models/model.php');
class Page extends Model {
	public $city;
	public $state;
	public $destinations;
	public $cities;
	public $weather;
	public $itinerary;
	public $locations;
	public $markers;
	public $users;

	public function __construct($params){
		parent::__construct();
	}		
		
	public function get_destinations(){
		$query = "SELECT d.url, d.img_url, d.tags, d.destination_name, d.destination_id, r.user_id, r.review, r.score 
					FROM ".$this->global_db.".sites_destinations AS sd 
					JOIN ".$this->global_db.".destinations AS d 
					ON sd.destination_id = d.destination_id 
					LEFT JOIN ".$this->site_db.".reviews AS r 
					ON d.destination_id = r.destination_id 
					INNER JOIN ".$this->global_db.".destinations_cities AS dc 
					ON d.destination_id = dc.destination_id 
					INNER JOIN ".$this->global_db.".cities AS c 
					ON dc.city_id = c.city_id 
					WHERE c.city='".strtolower($this->city)."'
				    AND sd.site_id=".$this->site_id."
					ORDER BY sd.sort ASC, r.user_id ASC";
		$result = $this->db->query($query);
		$rows = $result->num_rows;
		if ($rows > 0){
			$page = array();
			for ($i=0;$i<$rows;$i++){
				$row = $result->fetch_assoc();
				if (strstr($row['url'], 'http://')){ 
					$url = substr($row['url'],7);
					if (substr($url,-1) == '/'){
						$url = substr($url,0,-1);
					}
				}
				else { 
					$url = $row['url'];
				}
				if ($row['img_url'] == null){
					$imgsrc = '/trip/assets/img/venue/noimage.jpg';
				}
				else {
					$imgsrc = '/trip/assets/img/venue/'.$row['img_url'];
				}

				if (empty($row['tags'])){
					$tags = '';
				}
				else {
					$tags = "[".$row['tags']."]";
				}

				if (!isset($page[$row['destination_name']])){
					$page[$row['destination_name']] = array('id'=>$row['destination_id'],'image'=>$imgsrc,'tags'=>$tags,'url'=>$url,'longurl'=>$row['url'],'fonda'=>'Nothing yet.','fscore'=>'','meg'=>'Nothing yet.','mscore'=>'');
				}
				$score = '';
				for ($p=1;$p<=5;$p++){
					if ($p<=$row['score']){
						$score .= "<img src='/trip/assets/img/full_star_small.png'>";
					}
					else {
						$score .= "<img src='/trip/assets/img/empty_star_small.png'>";
					}
				}

				$sql = "SELECT u.user_id, u.username FROM ".$this->global_db.".users AS u 
						LEFT JOIN ".$this->global_db.".users_sites AS us 
						ON us.user_id = u.user_id WHERE us.site_id = ".$this->site_id." OR us.site_id = 0";
				$u = $this->db->query($sql);
				if ($u && $u->num_rows)
				{
					$users = array();
					while ($urow = $u->fetch_assoc())
					{
						$users[$urow['user_id']] = $urow;
						$this->users[$urow['user_id']] = $urow;
					}
					$u->free_result();
				}

				if (array_key_exists($row['user_id'], $users))
				{
					$page[$row['destination_name']]['users'][] = array('userid'=>$row['user_id'], 'username'=>strtolower($users[$row['user_id']]['username']), 'review'=>$row['review'], 'score'=>$score);
				}
				else
				{
					$page[$row['destination_name']]['users'] = array();
				}

				/*
				if ($row['user_id'] == 3){
					$page[$row['destination_name']]['fonda'] = $row['review'];
					$page[$row['destination_name']]['fscore'] = $score;
				}
				else if ($row['user_id'] == 1){
					$page[$row['destination_name']]['meg'] = $row['review'];
					$page[$row['destination_name']]['mscore'] = $score;
				}
				*/
			}
			$result->free_result();
		}
		else {
			$page = NULL;
		}
		return $page;
	}
}
?>
