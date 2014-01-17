<?php
	$locations = $page->locations;
	$current_location = reset($locations);
	$curr_title = str_replace("'","&#039;",$current_location['destination_name']);;
	$currAddress = $current_location['address'] . ' '. $current_location['city'] . ' '. $current_location['state'] . ' , ' . $current_location['zip'];
	$center_lat = 0;
	$center_long = 0;
	$max_lat = 0;
	$min_lat = 0;
	$max_long = 0;
	$min_long = 0;
	$i = 0;
		
	foreach($locations as $location)
	{
		if ($location['latitude'] > $max_lat || $i == 0) {
				$max_lat = $location['latitude'];
		}
						
		if ($location['latitude'] < $min_lat || $i == 0) {
			$min_lat = $location['latitude'];
		} 
						
		if ($location['longitude'] > $max_long || $i == 0) {
			$max_long = $location['longitude'];
		}
						
		if ($location['longitude'] < $min_long || $i == 0) {
			$min_long = $location['longitude'];
		}  
	
		$i++;
	}
	
	$center_lat = ($max_lat + $min_lat) / 2;
	$center_long = ($max_long + $min_long) / 2;
	$center_pos = $center_lat . ', ' . $center_long;
	$json_locations = $page->markers;
	
?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC5RcAojaArnxZCI01c7fUmVsqjZNCrK_8&sensor=false"></script>

<script type="text/javascript">
$(function(){
	var map;
	var directionsPanel;
	var directions;
	var center;
	var overlay;
	var num_of_locations = <?php echo count($locations);?>;
	$('.startAdd').focus();
		
	var maxLat = <?php echo $max_lat?>;
	var minLat = <?php echo $min_lat?>;
	var maxLon = <?php echo $max_long?>;
	var minLon = <?php echo $min_long?>;
	var boundOffset = 0.0;
	var marker_icon = '/trip/assets/img/marker.png';
	var maxLatLong = new google.maps.LatLng(maxLat,maxLon+boundOffset);
	var minLatLong = new google.maps.LatLng(minLat,minLon-boundOffset);
		
	function initialize() {
		var bounds = new google.maps.LatLngBounds(minLatLong,maxLatLong);

		var myOptions = {
			center: new google.maps.LatLng(<?php echo $current_location['latitude'];?>, <?php echo $current_location['longitude'];?>),
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		if(num_of_locations != 1) map.fitBounds(bounds);
		var data = <?php echo $json_locations ?>;
	
		var infowindow = new google.maps.InfoWindow({
			maxWidth: '300px'
		});
			
		$.each(data,function(location,locationInfo){
			var lat = locationInfo.latitude;
			var lng = locationInfo.longitude;
			var currTitle = locationInfo.destination_name;
			var latLng  = new google.maps.LatLng(lat, lng);
			var url = currTitle;
			if (locationInfo.url)
			{
				url = '<a href="'+locationInfo.url+'" target="_blank">'+currTitle+'</a>';
			}

			var infoImg = '<img width="70px" src="'+locationInfo.img_url+'"/>';
			var content;
				
			content = '<div class="loc_title">' +
					'<p>'+url+'</p>' +
					'<p>'+locationInfo.address1+'</p>' +
					'<p>'+locationInfo.address2+'</p>' +
					'<p id="check_'+locationInfo.location_id+'"><a class="checkin" href="#">Check-in at this location</a></p></div>';
			var marker = new google.maps.Marker({
				position: latLng,
				map: map,
				title: currTitle,
				icon: marker_icon
			});
				 
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.close();
				var latlongval = locationInfo.latitude + ',' + locationInfo.longitude;
				$('#endAddress').val(latlongval);
				infowindow.setContent(content);
				infowindow.open(map, marker);
				$('.checkin').bind('click', function(event){
					event.preventDefault();
					$.ajax({
						url: '/<?php echo $page->site_url; ?>/check_in/',
						async: false,
						cache: false,
						type: 'post',
						dataType: 'text',
						data: {'location_id': locationInfo.location_id, 'user_id': 2},
						success: function(response){
							if (response)
							{
								$('#check_'+locationInfo.location_id).html('<b>Checked In!</b>');
								$('#destination_' + locationInfo.destination_id).css('border', '5px solid black').css('background-color','#F2FFA8');
							}
						}
					});
				});
			});
		});
	}
	google.maps.event.addDomListener(window, 'load', initialize);	
});
</script>


<div id="results"></div>

<!-- Google Map Division -->
<div id="map_container">
	<div id="map_canvas"></div>
</div>
<!-- End Google Map -->

<div class="clear"></div>

