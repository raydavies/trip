$(document).ready(function(){
	$('#add_form').submit(function(){
		if ($('.add:checked').length > 0){
			$('#add_error').text('');
			return true;
		}
		else {
			$('#add_error').text('Please select one or more locations to add to itinerary.');
			return false;
		}
	});
	$check = $('input[type=checkbox]');
	$check.each(function(){
		$(this).change(function(event){
			if ($(this).is(':checked')){
				$(this).siblings().eq(0).css('background', '#fff').css('color','rgba(0,0,0,0.65)');
			}
			else {
				$(this).siblings().eq(0).css('background', 'none').css('color','rgba(0,0,0,1)');
			}
		});
	});
});
