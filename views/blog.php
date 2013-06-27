<?php
if (!isset($_SESSION)){
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $blog->site_name; ?> Blog</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

<link rel="stylesheet" href="/trip/assets/css/fonts.css" type="text/css">
<link rel="stylesheet" href="/trip/assets/css/blog.css" type="text/css">

<!--scripts for adobe fonts-->
<script type="text/javascript" src="//use.typekit.net/xfa2uul.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>

</head>
<body>
<div id="head_wrapper">
	<div id="header">
		<header id="title">
		<h1><?php echo $blog->site_name; ?> Blog</h1>
		</header>

		<nav>
			<ul>
<?php
include_once(BASEPATH.'/models/locationmodel.php');
$location = new Location;
$cities = $location->get_site_cities();
	foreach ($cities as $city){
?>			
				<a href='/<?php echo $blog->site_url; ?>/<?php echo strtolower($city['city']."-".$city['state']);?>/'><li><?php echo $city['city']; ?></li></a>
<?php
	}
?>
			</ul>
		</nav>
	</div>
</div><!--END HEAD WRAPPER-->
<div id="container">
	<section id="blog_wrapper">
<?php
	$entries = $blog->get_entries();
	foreach ($entries as $entry)
	{
		echo "<p>";
		echo "<span class='entry-date'>".$entry['date']." ".$entry['time']."</span>";
		echo "<br>";
		echo $entry['entry'];
		echo "<br>";
		echo "<span class='signature'>~ ".$entry['username']."</span>";
		echo "</p>";
	}
?>

	</section>
<?php
	if (isset($_SESSION['username'])){
?>
		<div id="new_post">
			<h1>Create a New Post</h1>
			<form id="blog_form" method="post" action=''>
				<input type="hidden" id="bloggername" name="name" value="<?php echo $_SESSION['username']; ?>">
				<textarea id="blog_text" name="blog_text" required="required" placeholder="Type <br> for line break."></textarea><br>
				<input type="submit" value="Submit Post">
			</form>
		</div>
<?php
	}
	else {
?>
	<a id="backlink" href="/<?php echo $blog->site_url; ?>/admin/login/">Log In To Post</a><br>
<?php
	}
?>
	<a id="backlink" href='/<?php echo $blog->site_url; ?>/'>Back</a>
</div>
</body>
</html>
