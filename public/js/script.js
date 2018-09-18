$(document).ready(function()
{
	$('.textarea').ckeditor();        


	$('.follow-button').click(function()
	{
		var link_id = $(this).data('id');

		$.ajax({
			url: '/stacks/' + link_id + '/follow',
			type: 'get',
			dataType: 'json',
			success: function()
			{

			}
		});
		
	});
});