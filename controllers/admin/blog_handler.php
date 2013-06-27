<?php
if (!isset($_SESSION))
{
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
ob_flush();

if (isset($_SESSION['username']) && isset($_SESSION['userid']))
{
	if (!empty($_POST))
	{
		$name = trim($_POST['name']);
		$post = trim($_POST['blog_text']);
	}

	if (empty($post) || empty($name))
	{
		$page->title = 'Submit Error';
		$title = 'Submission Error!';
		$info = array('There was an error in submitting your post. Please click the link below to go back and try again.');
		$links = array();
		$links[] = array('url'=>'../blog/','title'=>'Back to Blog Entry');
		$links[] = array('url'=>'/'.$page->site_url.'/admin/','title'=>'Admin Options');
	}
	else
	{
		$name = $page->db->real_escape_string($name);
		$post = $page->db->real_escape_string($post);

		$userid = $_SESSION['userid'];

		$query = "INSERT INTO ".$page->site_db.".blog(userid,entry) VALUES ('".$userid."','".$post."')";
		$result = $page->db->query($query);
		$result->free_result();

		$page->title = 'Success!';
		$title = 'Blog Post Added!';
		$info = array(stripslashes($post));
		$timestamp = "Submitted by ".ucwords($name)." at ".date('g:ia');
		$links = array();
		$links[] = array('url'=>'/'.$page->site_url.'/admin/','title'=>'Admin Options');
	}
	include_once(VIEWPATH.'/admin/blog_handler.php');
}
else
{
	header("Location: /".$page->site_url."/admin/login/");
	die;
}
?>


