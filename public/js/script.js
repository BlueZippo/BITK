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



$(document).on('keydown', '.comment-form textarea[name=comment]', function(e)
{
	if (e.which == 13)
	{
		var params = $('.comment-form form').serialize();

		var stack_id = $('.comment-form input[name=stack_id]').val();

		e.preventDefault();

		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });

	    $.ajax(
		{
			url: "/stack_comments/store",
			data: params,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('.modal-body .comment-list').html(data.html);

				$('#stack' + data.stack_id + ' .comments-button').html('<i class="fa fa-comments"></i>' + data.comments)

				$('textarea[name=comment]').val('');
			}
		});
	}

});

$(document).on('keydown', '.link-comment-form textarea[name=comment]', function(e)
{
	if (e.which == 13)
	{
		var params = $('.link-comment-form form').serialize();

		var stack_id = $('.link-comment-form input[name=link_id]').val();

		e.preventDefault();

		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });

	    $.ajax(
		{
			url: "/link_comments/store",
			data: params,
			type: 'post',
			dataType: 'json',
			success: function(data)
			{
				$('.modal-body .comment-list').html(data.html);

				$('textarea[name=comment]').val('');
			}
		});
	}

})


$(document).ready(function()
{
	$('.search-wrapper a.input-button').click(function()
	{
		var ss = $('.search-wrapper input[name=search]').val();

		if (ss.length > 0)
		{
			$('.search-wrapper form').submit();
		}
	});


	$('.add-a-link-button').click(function()
	{
		var offset = $(this).offset();
		console.log( "left: " + offset.left + ", top: " + offset.top );

		if (offset.top > 110)
		{
			$('.add-link-form').css('top', (offset.top - 35) + 'px');
		}
		else
		{
			$('.add-link-form').css('top', '80px');
		}

		$('.add-link-form').css('left', (offset.left + 130) + 'px');

		$('.add-link-form').show();
	});

	$('.cancel-btn').click(function()
	{
		$('.add-link-form').hide();
	});

	$('.continue-button').click(function()
	{
		$('.add-link-form .step1').hide();
		$('.add-link-form .step2').show();
		$('.add-link-form .submit-button').show();
		$('.back-button').show();
		$(this).hide();
	});

	$('.back-button').click(function()
	{
		$('.add-link-form .step1').show();
		$('.add-link-form .step2').hide();
		$('.add-link-form .submit-button').hide();
		$('.add-link-form .continue-button').show();
		$(this).hide();
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
				$('.upvote').html('<i class="thumbsup"></i> ' + data.upvote);
				$('.downvote').html('<i class="thumbsdown"></i> ' + data.downvote);
			}
		})
	});

	$('.approve-button').on('click', function()
	{
		var stack_id = $(this).data('id');

		var params = 'stack_id=' + stack_id + '&vote=1';

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
				$('#stack' + stack_id + ' .stack-footer .approve-button').html('<i class="fa fa-thumbs-up"></i> ' + data.upvote);
				$('#stack' + stack_id + ' .stack-footer .disapprove-button').html('<i class="fa fa-thumbs-down"></i> ' + data.downvote);

				$('#stack' + stack_id + ' .list-button .upvotes').html(data.upvote);
			}
		})
	});

	$('.disapprove-button').on('click', function()
	{
		var stack_id = $(this).data('id');

		var params = 'stack_id=' + stack_id + '&vote=0';

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
				$('#stack' + stack_id + ' .stack-footer .approve-button').html('<i class="fa fa-thumbs-up"></i> ' + data.upvote);
				$('#stack' + stack_id + ' .stack-footer .disapprove-button').html('<i class="fa fa-thumbs-down"></i> ' + data.downvote);

				$('#stack' + stack_id + ' .list-button .upvotes').html(data.upvote);
			}
		})
	});

	$('.likes .like').on('click', function()
	{
		var stack_id = $(this).data('id');

		var params = 'stack_id=' + stack_id + '&vote=1';

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
				$('#stack' + stack_id + ' .like').html('<i class="fas fa-thumbs-up"></i> ' + data.upvote);
				$('#stack' + stack_id + ' .dislike').html('<i class="fas fa-thumbs-down"></i> ' + data.downvote);
			}
		})
	});

	$('.likes .dislike').on('click', function()
	{
		var stack_id = $(this).data('id');

		var params = 'stack_id=' + stack_id + '&vote=0';

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
				$('#stack' + stack_id + ' .like').html('<i class="fas fa-thumbs-up"></i> ' + data.upvote);
				$('#stack' + stack_id + ' .dislike').html('<i class="fas fa-thumbs-down"></i> ' + data.downvote);
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

    $('.media-types input[type=checkbox]').click(function()
    {
    	$('.media-types input[type=checkbox]').prop('checked', false);
    	$(this).prop('checked', true);
    	$('input[name=media_id]').val($(this).val());
    });

    $('.link-comment-button').click(function()
    {
    	var id = $(this).data('id');

    	$.ajax(
    	{
    		url: '/link_comments/' + id + '/comments',
    		type: 'get',
    		dataType: 'json',
    		success: function(data)
    		{
    			$('#popupComments .modal-body').html(data.html)

    			$('#popupComments').modal();
    		}
    	})


    });

    $('a.chats, a.comments-button').click(function()
    {
    	var id = $(this).data('id');

    	$.ajax(
    	{
    		url: '/stacks/' + id + '/comments',
    		type: 'get',
    		dataType: 'json',
    		success: function(data)
    		{
  				$('#popupComments .modal-body').html(data.html);

  				$('#popupComments').modal();
    		}

    	});
    });

    $('.view-button a').click(function()
    {
    	var bClass = $(this).attr('class');

    	$('.stack-list').removeClass('tile');
    	$('.stack-list').removeClass('compact');
    	$('.stack-list').removeClass('list');

    	$('.stack-list').addClass(bClass);

    	$.totalStorage('display', bClass);
    });

	mobile_menu($);
	single_stack($);
	equal_heights($);
	dashboard_controls($);

});

function mobile_menu($) {

	$('.mobile-nav li.with-menu > a').on('click', function() {

		var trigger = $(this);
		var menu = $(this).siblings('.sub-menu');

		if( !menu.hasClass('show') ) {
			menu.addClass('show').find('.inner').animate({ height: 'show', opacity: 1 });
			trigger.addClass('open');
		} else {
			menu.removeClass('show').find('.inner').animate({ height: 'hide', opacity: 0 });
			trigger.removeClass('open');
		}

	});

}

function single_stack($) {

	var button = $('.accordion.stack-single .card-header > button');

	if( button.length ) {

		button.on('click', function() {

			if( !$(this).hasClass('open') ) {
				$(this).addClass('open');
			} else {
				$(this).removeClass('open');
			}
		});

	}

}

function equal_heights($) {

	$('.stack-links .single-link .title').matchHeight({
		byRow: false,
	    property: 'height'
	});

	// Dashboard Tiles
	$('.dash-stack-tile > .stack-content').matchHeight({
		byRow: false,
	    property: 'height'
	});

	$('.dash-stack-tile > .stack-content > .title').matchHeight({
		byRow: false,
	    property: 'height'
	});

	//Dashboard People
	$('.stack-panel-people .people-box').matchHeight({
		byRow: false,
	    property: 'height'
	});

}

function dashboard_controls($) {

	// Dashboard Layout Controls
	$('.layout-control > .btn-control').on('click', function() {
		$('.layout-control > .btn-control').removeClass('active');
		$(this).addClass('active');
	});

}
