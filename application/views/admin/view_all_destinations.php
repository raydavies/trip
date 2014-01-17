<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Add Destinations</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/destination.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="/trip/assets/js/addItem.js"></script>
</head>

<body>
<div id="destination_list">
<h2>Add Destinations</h2>
<div id="inner_list">
<p class="subheader">Click a destination to view the website in a new tab, or check the box next to a name and click 'Add Selected Locations' at the bottom of the page to add the destination to the itinerary.</p>

<?php
	if (!empty($places))
	{
		echo '<form id="add_form" method="post" action="../add_handler">';
		foreach ($places as $place)
		{
			echo "<p class='list_item'>";
			echo "<input type='checkbox' class='add' name='add[]' value='".$place['destination_id']."'>";
			echo "<a class='list_link' href='".$place['url']."' target='_blank'>".$place['destination_name']." - ".$place['city']."</a>";
			echo "<br>";
			if (!empty($place['tags'])){
				echo "<span class='tags'>".$place['tags']."</span><br>";
			}
			echo "</p>";
		}
		echo "<span id='add_error'></span><br>";
		echo "<input type='submit' class='add_btn' value='Add Selected Locations'>";
		echo "</form>";
	}
?>

<a class="homelink" href="/<?php echo $page->site_url; ?>/admin/">Back</a>
</div>
</div>
</body>
</html>
