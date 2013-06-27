<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Admin</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/admin.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>
<div id="container">
	<div id="content_wrapper">
		<h1>Welcome, <?php echo ucwords($_SESSION['username']); ?>!</h1>
	<nav id="admin_nav">

	<a href="/<?php echo $page->site_url; ?>/admin/create_destination/">Create a Destination</a>
	<a href="/<?php echo $page->site_url; ?>/admin/view_all_destinations/">Add Destinations To Itinerary</a>
	<a href="/<?php echo $page->site_url; ?>/admin/view_destination/">Remove Destinations From Itinerary</a>
	<a href="/<?php echo $page->site_url; ?>/admin/itinerary/">Trip Itinerary</a>
	<a href="/<?php echo $page->site_url; ?>/admin/reviews/">Write a Review</a>
	<a href="/<?php echo $page->site_url; ?>/admin/blog/">Write a Blog Entry</a>
	<a href="/<?php echo $page->site_url; ?>/">Back to Site Home</a>

	</nav>

	<a href="/<?php echo $page->site_url; ?>/admin/logout/">Log Out</a>
	</div>

</div>
</body>
</html>
