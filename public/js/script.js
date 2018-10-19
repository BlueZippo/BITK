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
		var action = $(this).val();

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
					$('.people-' + people_id + ' .follow-people-button').val('Unfollow');
					$('.people-' + people_id + ' .follow-people-button').attr('data-action', 'unfollow')
				}
				else
				{
					$('.people-' + people_id + ' .follow-people-button').val('Follow');
					$('.people-' + people_id + ' .follow-people-button').attr('data-action', 'follow')
				}
			}
		});
	});

	$('.tags-container span').on('click', function()
	{
		var id = $(this).data('id');

		$.ajax(
		{
			url: '/tags/' + id + '/delete',
			type: 'get',
			dataType: 'json',
			success: function()
			{
				$('#tag' + id).remove();		
			}
		})

		
	})
	
});