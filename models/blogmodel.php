<?php
require_once('models/model.php');
class Blog extends Model {
	public $blog;

	public function __construct(){
		parent::__construct();
	}

	public function get_entries($limit=NULL)
	{
		if (isset($limit))
		{
			$limit = " LIMIT ".$limit;
		}
		else
		{
			$limit = '';
		}

		$query = "SELECT u.username, b.entry, b.entry_date 
					FROM ".$this->site_db.".blog AS b, 
					".$this->global_db.".users AS u
					WHERE u.user_id = b.user_id  
					ORDER BY b.entry_date DESC".$limit;
		$result = $this->db->query($query);
		if ($result && $result->num_rows)
		{
			$blog = array();
			while ($row = $result->fetch_assoc())
			{
				$newdate = date_create($row['entry_date']);
				$blog[] = array('date'=>date_format($newdate,'l, F j'), 
							  'time'=>date_format($newdate,'g:ia'),
							  'entry'=>$row['entry'],
							  'username'=>$row['username']);
			}
			$result->free_result();
			return $blog;
		}
		return null;
	}
}
?>


