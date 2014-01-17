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
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title><?php echo $page->city; ?></title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/cities.css">
<script type="text/javascript" src="//use.typekit.net/xfa2uul.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>
<div id="head_wrapper">
	<div id="header">
		<h1><?php echo $page->city; ?></h1>
		<nav>
			<ul>
			<a href='/<?php echo $page->site_url; ?>/'><li>Home</li></a>
<?php
if (isset($page->cities)){
	foreach ($page->cities as $city){
		if (strtolower($city['city']) !== strtolower($page->city)){
?>
				<a href='/<?php echo $page->site_url; ?>/<?php echo strtolower($city['city']."-".$city['state']);?>/'><li><?php echo $city['city']; ?></li></a>
<?php
		}
	}
}
?>
			</ul>
		</nav>
	</div>
</div>

<div id="content_wrapper">
	<div id="content">
		<div id='itinerary_wrapper'>
			<h3>Itinerary</h3>
<?php
if (isset($page->itinerary)){
	foreach ($page->itinerary as $day){
		echo "<p>";
		echo "<time datetime=".$day['datetime'].">".$day['date']."</time><br>";
		echo "<span>".$day['details']."</span>";
		echo "</p>";
	}
}
else {
	echo "<p>No itinerary for this city yet.</p>";
}
?>
		</div>
<?php
echo $page->weather;

if (!isset($page->destinations)){
	if (!isset($_SESSION['username'])){
		echo "<p id='city_disclaimer'>We haven't added any destinations to this city's itinerary yet, but check back soon to see where we end up!</p>";
	}
	else {
		echo "<p id='city_disclaimer'>Click <a href='/".$page->site_url."/admin/view_all_destinations.php'>&gt;HERE&lt;</a> to start adding destinations to this page.</p>";
	}
}
else {
	foreach ($page->destinations as $name=>$value){
?>
		<div class="destination" id="destination_<?php echo $value['id']; ?>">
			<h2 class="venue-name"><a href="/<?php echo $page->site_url; ?>/admin/reviews/?id=<?php echo $value['id']; ?>"><?php echo $name; ?></a></h2>
			<section class="venue">
				<img src="<?php echo $value['image']; ?>">
				<h5><?php echo $value['tags']; ?></h5>
				<a href="<?php echo $value['longurl']; ?>" target="_blank"><?php echo $value['url']; ?></a>
			</section>

			<section class="reviews">
<?php if (!empty($page->destinations[$name]['users']))
	{
		$rand = rand(0, count($page->destinations[$name]['users'])-1);
		$user = $page->destinations[$name]['users'][$rand];
		$uname = strtolower($user['username']);
?>
				<article class="<?php echo $uname; ?>">
					<img class="<?php echo $uname; ?>icon" src="/trip/assets/img/<?php echo $uname; ?>frame.jpg">
					<h4><?php echo ucwords($uname); ?> says...</h4>
					<span><?php echo $user['score']; ?></span>
					<p><?php echo $user['review']; ?></p>
				</article>
<?php
	}
?>
			</section>
			<br class="fl_c">
		</div>
<?php
	}
}
?>
	</div>
	<br class="clr-btm">
</div>

<div id="foot_wrapper">
	<div id="footer">
		<?php 
			if (isset($page->locations)){
				include_once(BASEPATH.'/views/map.php');
			}
		?>
	</div>
</div>
</body>
</html>
