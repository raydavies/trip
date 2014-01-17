<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>View/Delete Destinations</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/destination.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="/trip/assets/js/deleteItem.js"></script>
</head>

<body>
<div id="destination_list">
<h2>View/Delete Destinations</h2>
<div id="inner_list">
<p class="subheader">Click a destination to view the website in a new tab, or check the box next to a name and click 'Delete Selected Locations' at the bottom of the page to remove the destination from the itinerary.</p>

<?php
	if (!empty($places))
	{
		echo '<form id="delete_form" method="post" action="../delete_handler">';
		foreach ($places as $place)
		{
			echo '<p class="list_item">';
			echo '<input type="checkbox" class="delete" name="delete[]" value="'.$place['destination_id'].'">';
			echo '<a class="list_link" href="'.$place['url'].'" target="_blank">'.$place['destination_name'].' - '.$place['city'].'</a><br>';

			if (!empty($place['tags']))
			{
				echo '<span class="tags">'.$place['tags'].'</span><br>';
			}
			echo '</p>';
		}
		echo '<span id="delete_error"></span><br>';
		echo '<input type="submit" class="delete_btn" value="Delete Selected Locations">';
		echo '</form>';
	}
	else
	{
		echo '<p><a href="../view_all_destinations/">No destinations have been added yet. Click here to start.</a></p>';
	}
?>

<a class="homelink" href="/<?php echo $page->site_url; ?>/admin/">Back</a>
</div>
</div>
</body>
</html>
