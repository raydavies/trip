<?php
$_SESSION['errormsg'] = '';
if (empty($_SESSION['redirect']))
{
	$_SESSION['redirect'] = '/'.$page->site_url.'/admin/';
}
function cleanData($data)
{
	if (get_magic_quotes_gpc()) {
		$data = stripslashes($data);
	}
		$data = str_replace("\n", '', trim($data));
		$data = str_replace("\r", '', $data);
		return $data;

}
if (isset($_POST['username']) && isset($_POST['password'])) {

	$username = cleanData($_POST['username']);
	$password = cleanData($_POST['password']);
	
	$query = "SELECT * FROM ".$page->global_db.".users AS u 
				LEFT JOIN ".$page->global_db.".users_sites AS us
				ON us.user_id = u.user_id
				WHERE LOWER(u.username)='".$username."' AND u.password=sha1('".$password."') AND (us.site_id = ".$page->site_id." OR us.site_id = 0) LIMIT 1";

	$result = $page->db->query($query);
	if ($result && $result->num_rows)
	{
		$row = mysqli_fetch_array($result);
		$_SESSION['username'] = $username;
		$_SESSION['userid'] = $row['user_id'];
	}
	$result->free_result();
}

if (isset($_SESSION['username'])) {
	header('Location: '.$_SESSION['redirect']);
	 die;	
	//$_SESSION['errormsg'] = '';
	//include_once($params['pathname']);
}
else {
	if (isset($username)) {
		$_SESSION['errormsg'] = "Invalid Login!";
	}
	include_once(VIEWPATH.'/admin/login.php');
}
?>
