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

	$('.follow-people-button').click(function()
	{
		var people_id = $(this).data('id');
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
			url: '/people/' + people_id + '/' + action,
			type: 'get',
			dataType: 'json',
			success: function(data)
			{
				if (action == 'follow')
				{	
					$('.people-' + people_id + ' .follow-people-button').html('Unfollow');
					$('.people-' + people_id + ' .follow-people-button').attr('data-action', 'unfollow')
				}
				else
				{
					$('.people-' + people_id + ' .follow-people-button').html('Follow');
					$('.people-' + people_id + ' .follow-people-button').attr('data-action', 'follow')
				}
			}
		});
	});
});