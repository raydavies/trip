<?php
require_once(BASEPATH.'/models/blogmodel.php');
$blog = new Blog;

if (isset($_POST['blog_text']) && isset($_SESSION['userid'])){
	$post = trim($_POST['blog_text']);
	$post = $blog->db->real_escape_string($post);
	$query = "INSERT INTO ".$blog->site_db.".blog(user_id,entry) 
				VALUES ('".$_SESSION['userid']."','".$post."')";
	$blog->db->query($query);
}
include_once(VIEWPATH.'/blog.php');
?>
