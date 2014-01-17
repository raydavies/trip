$(document).ready(function(){
	$('#delete_form').submit(function(){
		if ($('.delete:checked').length > 0){
			$('#delete_error').text('');
			return true;
		}
		else {
			$('#delete_error').text('Please select one or more locations to delete.');
			return false;
		}
	});
	$check = $('input[type=checkbox]');
	$check.each(function(){
		$(this).change(function(event){
			if ($(this).is(':checked')){
				$(this).siblings().eq(0).css('text-decoration', 'line-through').css('color','rgba(0,0,0,0.65)');
			}
			else {
				$(this).siblings().eq(0).css('text-decoration', 'none').css('color','rgba(0,0,0,1)');
			}
		});
	});
});
