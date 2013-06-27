<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Create Destination</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/destination.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="/trip/assets/js/latlong.js"></script>
</head>

<body>

<div id="content_wrapper">
<h1>Enter Your Destination</h1>

<div id="create_form">
<p>Name, Address, and City are required. Check any tags that may apply.</p>

<form method="Post" id="destination_form" action="create_handler">
	<label>Establishment Name</label>
	<input type="text" name="name" required="required"><br>
	<label>Establishment URL</label>
	<input type="text" name="url"><br>
	<label>Address</label>
	<input type="text" name="address" required="required"><br>

<?php
	if (!empty($city_opts))
	{
		echo '<div id="select">';
		echo '<label>City</label>';
		echo '<select name="city">';
		foreach ($city_opts as $city)
		{
			echo '<option value="'.$city['name'].'">'.$city['name'].'</option>';
		}
		echo '</select>';
		echo '</div>';
	}
?>

	<label for="state">State</label>
	<input id="state" type="text" name="state" required="required" maxlength="2"><br>

	<div id="hidden_fields">
		<input type="hidden" id="latitude" name="latitude" value=''>
		<input type="hidden" id="longitude" name="longitude" value=''>
		<input type="hidden" id="zipcode" name="zipcode" value=''>
	</div>

	<p>Add some tags for this location (e.g. Bar, Restaurant, Hotel) separated by commas.</p>
	<input id="tags" type="text">

	<div id="tag_bin"></div>

	<input type="submit" value="Enter">
</form>
</div>

<a class="homelink" href="/<?php echo $page->site_url; ?>/admin/">Back</a>
</div>
</body>
</html>
<script type="text/javascript">
$(window).load(function(){
	state_lookup();
	$('select[name="city"]').change(state_lookup);
});
function state_lookup(){
	var city = $('#select option:selected').val();
		$.ajax({
			url: '/<?php echo $page->site_url; ?>/state_lookup/',
			async: false,
			dataType: 'text',
			data: {'city': city},
			success: function(response){
				$('#state').val(response);
			}
		});
}
</script>
