<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Trip Planner</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/map.css">
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script>
$(window).load(function() {
	$('#datepicker').datepicker();
	$('#anim').change(function(){
		$('#datepicker').datepicker('option', 'showAnim', $(this).val());
	});
});
</script>
</head>
<body>
	<div id="itinerary_wrapper">
		<div id="inner_itinerary">
		<h1>Add Daily Itinerary</h1>
		<form id="itinerary_form" method="post" action='itinerary_handler'>
			<label>Date</label>
			<input type="text" id="datepicker" name="date" required="required">
<?php
			if (!empty($city_opts))
			{
				echo '<div id="select">';
				echo '<label>City</label>';
				echo '<select name="city_id">';
				foreach ($city_opts as $city)
				{
					echo '<option value="'.$city['city_id'].'">'.$city['name'].'</option>';
				}
				echo '</select>';
				echo '</div>';
			}
?>
			<label>Details</label>
			<textarea id="details" name="details" required="required" placeholder="Type <br> for line break."></textarea><br>
			<input type="submit" value="Submit Post">
		</form>
		<a class="backlink" href="/<?php echo $page->site_url; ?>/admin/">Back</a>
		</div>
	</div>
</body>
</html>
