<?php
if (!isset($_SESSION)){
	session_start();
	$_SESSION['http_referer'] = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
ob_flush();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>404</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

<link rel="stylesheet" href="/trip/assets/css/fonts.css" type="text/css">
<link rel="stylesheet" href="/trip/assets/css/themes/<?php echo $page->theme; ?>/master.css" type="text/css">

<!--scripts for adobe fonts-->
<script type="text/javascript" src="//use.typekit.net/xfa2uul.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div id="head_wrapper">
	<div id="header">
		<header id="title">
		<h1><?php echo $page->site_name; ?></h1>
		</header>
		<nav>
			<ul>
<?php
include_once(BASEPATH.'/models/locationmodel.php');
$location = new Location;
$cities = $location->get_site_cities();
	foreach ($cities as $city){
?>			
				<a href='/<?php echo $page->site_url; ?>/<?php echo strtolower($city['city']."-".$city['state']);?>/'><li><?php echo $city['city']; ?></li></a>
<?php
	}
?>
			</ul>
		</nav>
	</div><!--END HEAD WRAPPER-->
</div>
<div id="content_wrapper">
	<div id="content">
		<h1>Error! 404</h1>
		<p id="error_text">Oops! Seems you've wandered off the edge of the map.<br>
Use the navigation menu above to find your way back on the trail.</p>
	</div>
</div>
</body>
</html>
