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
		$deletions = $_POST['delete'];
		if (isset($_POST['confirm']))
		{
			$confirm = $_POST['confirm'];
		}
	}
	if (empty($deletions))
	{
		$page->title = 'Request Error';
		$title = 'Request Error!';
		$info = array('There was an error in submitting your request. Please click the link below to go back and try again.');
		$links = array();
		$links[] = array('url'=>'../view_destination/','title'=>'Back to Destinations List');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	else if (empty($confirm))
	{
		$page->title = 'Delete Confirmation';
		$title = 'Delete From Itinerary?';
		$query = "SELECT destination_name 
				FROM ".$page->global_db.".destinations 
				WHERE destination_id IN (".implode(',', $deletions).")";
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
		$form = 'delete';
		$links = array();
		$links[] = array('url'=>'./view_destination/','title'=>'Back to Destinations List');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	else
	{
		$query = "DELETE FROM ".$page->global_db.".sites_destinations
				WHERE destination_id IN (".implode(',', $deletions).") 
				AND site_id = ".$page->site_id;
		$result = $page->db->query($query);
		if ($result)
		{
			$page->title = 'Success!';
			$title = 'Successfully Removed Destination(s)!';
			$links = array();
			$links[] = array('url'=>'./view_destination/','title'=>'Back to Destinations List');
			$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
		}
		else
		{
			$page->title = 'Request Error';
			$title = 'Request Error!';
			$info = array('There was an error in submitting your request. Please click the link below to go back and try again.');
			$links = array();
			$links[] = array('url'=>'../view_destination/','title'=>'Back to Destinations List');
			$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
		}
	}
	include_once(VIEWPATH.'/admin/delete_handler.php');
}
else {
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>
