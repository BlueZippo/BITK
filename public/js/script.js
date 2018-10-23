$(document).on('click', 'a.follow-button', function()
{
	stack_id = $(this).data('id');	
	action = $(this).attr('data-action');

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


	$('a.search-button').click(function()
	{
		var ss = $('.search-wrapper input[name=search]').val();

		if (ss.length > 0)
		{
			$('.search-wrapper form').submit();
		}	
	});


	$('button.set-reminder-link').click(function()
	{
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


		$.ajax(
		{
			url: '/links/addreminder',
			data: $('#reminderModal form').serialize(),
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('#reminderModal').modal('hide');
			}
		});		
	});	


	$('.upvote, .downvote').on('click', function()
	{
		var stack_id = $(this).data('id');

		var params = 'stack_id=' + stack_id + '&vote=1';

		if ($(this).hasClass('downvote'))
		{
			params = 'stack_id=' + stack_id + '&vote=0';
		}	

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

		$.ajax(
		{
			url: '/stacks/' + stack_id + '/vote',
			data: params,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('.upvote').html('Upvote  | ' + data.vote);
			}
		})
	});
	

	$('.follow-people-button').click(function()
	{
		var people_id = $(this).data('id');
		var action = $(this).attr('data-action');
		

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