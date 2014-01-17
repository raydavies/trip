$(document).ready(function(){
	$('#destination_form').submit(function(){
		var address = $('input[name="address"]').val();
		var city = $('#select option:selected').val();
		var state = $('#state').val();
		address = (address + ', '  + city + ', ' + state).replace(/ /gi, '+');
		$.ajax({
			url: 'http://maps.googleapis.com/maps/api/geocode/json',
			async: false,
			cache: false,
			dataType: 'json',
			data: {'address': address, 'sensor': false},
			success: function(json){
				$('#latitude').val(json.results[0].geometry.location.lat);
				$('#longitude').val(json.results[0].geometry.location.lng);
				var length = json.results[0].address_components.length;
				length = (length - 1).toString();
				$('#zipcode').val(json.results[0].address_components[length].short_name);
			}
		});
	});
	$('#tags').keypress(function(event){
		if (event.which == 44){
			event.preventDefault();
			var tags = $('#tags').val().replace(/,/g, '');
			if (tags != ''){
				var html = '<a class="delete-tag">x</a>' + tags;
				$span = $('<span/>').addClass('tag-btn').html(html);
				$('#tag_bin').append($span);
				$input = $('<input/>').attr('type','hidden').attr('name','tags[]').attr('value',tags).appendTo($('#hidden_fields'));
				$('.delete-tag').bind('click', delete_tag);
				$('#tags').val('');
			}
		}
		else {
			return;
		}
	});
});

function delete_tag(){
	$(this).parent('.tag-btn').remove();
	var tag = $(this).parent('.tag-btn').text().substring(1);
	if ($('input[value="'+tag+'"]'))
	{
		$('input[value="'+tag+'"]').remove();
	}
}
