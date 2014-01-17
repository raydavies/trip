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
		$date = $_POST['date'];
		$city_id = $_POST['city_id'];
		$details = trim($_POST['details']);
	}
	if (empty($details) || empty($date) || empty($city_id))
	{
		$page->title = 'Submit Error';
		$title = 'Submission Error!';
		$info = array('There was an error in submitting your plans. One or more fields did not post. Please click the link below to go back and try again.');
		$links = array();
		$links[] = array('url'=>'../itinerary/','title'=>'Back to Trip Planner');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	else
	{
		$details = $page->db->real_escape_string($details);
		$date = new DateTime($date);
		$datetime = date_format($date, 'Y-m-d H:i:s');

		$query = "INSERT INTO ".$page->site_db.".itinerary(datetime,city_id,details) VALUES ('".$datetime."','".$city_id."','".$details."')";
		$result = $page->db->query($query);

		require_once('../locationmodel');
		$loc = new Location;
		$city = $loc->get_city_by_id($city_id);

		$page->title = 'Success!';
		$title = 'Itinerary Details Added!';
		$info = array(date_format($date, 'l, F j')."<br>".$city."<br>".stripslashes($details));
		$timestamp = "Submitted at ".date('g:ia');
		$links = array();
		$links[] = array('url'=>'../itinerary/','title'=>'Add More');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/', 'title'=>'Admin Options');
	}
	include_once(VIEWPATH.'/admin/itinerary_handler.php');
}
else
{
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>


