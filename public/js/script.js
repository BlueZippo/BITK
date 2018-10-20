$(document).on('click', 'a.follow-button', function()
{
	stack_id = $(this).data('id');	
	action = $(this).attr('data-action');

	console.log(action);

	$.ajax(
	{
		url: '/stacks/' + stack_id + '/' + action,
		type: 'get',
		dataType: 'json',
		success: function(data)
		{
			var action = data.action;

			if (action == 'follow')
			{	
				$('#stack' + stack_id + ' .follow-button').html('<i class="fa fa-plus"></i> Saved');
				$('#stack' + stack_id + ' .follow-button').attr('data-action', 'unfollow')
			}
			else
			{
				$('#stack' + stack_id + ' .follow-button').html('<i class="fa fa-plus"></i> Save');
				$('#stack' + stack_id + ' .follow-button').attr('data-action', 'follow')
			}
		}
	});
	

});


$(document).ready(function()
{
	$('.textarea').ckeditor();        


	/*
	$('a.follow-button').on('click', function()
	{
		
		

		
		
	});
	*/

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