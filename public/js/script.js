$(document).ready(function()
{
	$('.textarea').ckeditor();        


	$('a.follow-button').click(function()
	{
		var stack_id = $(this).data('id');	
		var action = $(this).html();

		if (action == 'Follow')
		{
			action = 'follow'
		}
		else
		{
			action = 'unfollow';
		}	

		$.ajax({
			url: '/stacks/' + stack_id + '/' + action,
			type: 'get',
			dataType: 'json',
			success: function()
			{
				if (action == 'follow')
				{	
					$('.follow-button').html('Unfollow');
					$('.follow-button').attr('data-action', 'unfollow')
				}
				else
				{
					$('.follow-button').html('Follow');
					$('.follow-button').attr('data-action', 'follow')
				}
			}
		});
		
	});
});