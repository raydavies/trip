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
<title><?php echo $page->site_name; ?></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

<link rel="stylesheet" href="/trip/assets/css/fonts.css" type="text/css">
<link rel="stylesheet" href="/trip/assets/css/front.css" type="text/css">

<!--scripts for adobe fonts-->
<script type="text/javascript" src="//use.typekit.net/xfa2uul.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="/trip/assets/js/analyticstracking.js"></script>
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
	
	<div id="frame_left" class="frame">
		<div id="todo">
		<section>
			<header id="itinerary">
				<h1>Itinerary</h1>
			</header>
<?php
include_once(BASEPATH.'/models/itinerarymodel.php');
$itinerary = new Itinerary;
$plans = $itinerary->get_itinerary();
	foreach ($plans as $plan)
	{	
		echo "<p>";
		echo "<time datetime='".$plan['datetime']."'>".$plan['date']."</time>";
		echo "<br>";
		if (isset($plan['city'])) {
			echo $plan['city'];
		}
		if (isset($plan['state'])){
			echo ", ".$plan['state'];
			echo "<br>";
		}
		echo $plan['details'];
		echo "</p>";
	}
?>
		</section>
		</div>
	</div><!--END FRAME LEFT-->
	
	<div id="frame_right" class="frame">
		<div id="chalkboard">
		<section>
			<header id="blog">
				<h1><a id="bloglink" href="/<?php echo $page->site_url; ?>/blog/">Blog<span id="more"> (Scroll for more)</span></a></h1>
			</header>

<?php
	include_once(BASEPATH.'/models/blogmodel.php');
	$blog = new Blog;
	$entries = $blog->get_entries(5);
	foreach ($entries as $entry)
	{
		echo "<p>";
		echo $entry['date'];
		echo "<br>";
		echo $entry['time'];
		echo "<br>";
		echo $entry['entry'];
		echo "<br>";
		echo "~ ".$entry['username'];
		echo "</p>";
	}
?>

		</section>
		</div>
	</div><!--END FRAME RIGHT-->
	
	<div id="polaroid_wrapper">
		<section id="polaroid"></section>
		<a href="/<?php echo $page->site_url; ?>/admin/"><span id="greeting">Wish You Were Here!</span></a>
	</div>
</div><!--END CONTENT WRAPPER-->
</body>
</html>

