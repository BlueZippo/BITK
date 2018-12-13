<script src="{{ asset('js/plugins/chosen/chosen.jquery.min.js') }}"></script>

<link href="{{ asset('js/plugins/chosen/chosen.css') }}" rel="stylesheet">

<script>

var STACKS = {!!$MyStacks!!};


$(document).on('paste', 'input[name=link_url]', function(e)
{
    var clipboardData, pastedData;

    e.stopPropagation();
    e.preventDefault();

    clipboardData = e.clipboardData || window.clipboardData || e.originalEvent.clipboardData;
    
    pastedData = clipboardData.getData('Text');    

    $(this).val(pastedData);   

    $(this).trigger('change');

});

$(document).on('change', 'input[name=link_url]', function()
{
    $('.continue-button').addClass('disabled');

    $('.solid .content').html('Fetching link information, please wait...')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var linkUrl = $(this).val()

    linkUrl = linkUrl.replace(/&/g, ':::')

    $.ajax(
    {
        url: '/links/get-meta-tags',
        data: 'link_url=' + linkUrl,
        type: 'post',
        dataType: 'json',
        success: function(data)
        {
            $('*[data-field="link_title"] .content').html(data.title)

            $('*[data-field="link_description"] .content').html(data.description);

            if (data.image)
            {
                $('.image-container').html('<img src="'+data.image+'">');
            }

            if (data.media_types)
            {
                var media = data.media_types;

                for(var i=0; i< media.length; i++)
                {
                  $('.add-links-container .media-types input[type=checkbox]').each(function()
                  {
                    if ($(this).val() == media[i])
                    {
                        $(this).prop('checked', true);
                        $('.add-links-container input[name=media_id]').val(media[i])
                    }
                  })

                }  
            }

            $('input[name=link_description]').val(data.description);
            $('input[name=link_image]').val(data.image);
            $('input[name=link_title]').val(data.title);

            $('.continue-button').removeClass('disabled');
        }
    });
});

$('a.fa-edit').click(function()
{
    var par = $(this).parent();

    $('.content', par).each(function()
    {
        $(this).attr('contenteditable', true);

        if ($(this).html() == 'enter title...' || $(this).html() == 'enter description...')
        {
            $(this).html('');
        }

        $(par).removeClass('error');
        $(this).focus();
    });
});

$('.add-link-form .submit-button').click(function(e)
{

    e.preventDefault();

    e.stopPropagation();

    var par = $('.add-link-form form').serialize();

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/store',
        data: par,
        type: 'post',
        dataType: 'json',
        success: function(data)
        {
            if (data.redirect)
            {
                window.location = data.redirect
            }
            else
            {
                $('.parking-lot-container .panel-body').append(data.html);
            }
        }

    })


    $('.add-link-form').hide();
});

$('.parking-add-link-form .submit-button').click(function(e)
{

    e.preventDefault();

    e.stopPropagation();

    var par = $('.parking-add-link-form form').serialize();

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/store',
        data: par,
        type: 'post',
        dataType: 'json',
        success: function(data)
        {
            if (data.redirect)
            {
                window.location = data.redirect
            }
            else
            {
                $('.parking-lot-container .panel-body').append(data.html);
            }
        }

    })


    $('.parking-add-link-form').hide();
});

$(document).on('click', '.edit-parking-container .submit-button', function(e)
{

    e.preventDefault();

    e.stopPropagation();

    var par = $('.edit-parking-container form').serialize();

    var id = $('.edit-parking-container input[name=id]').val();

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/' + id + '/update',
        data: par,
        type: 'post',
        dataType: 'json',
        success: function(data)
        {
            if (data.redirect)
            {
                window.location = data.redirect
            }
            else
            {
                $('#link' + data.id).html(data.html);

            }
        }

    })


    $('.edit-parking-container').remove();
});


$(document).on('click', '.edit-link', function(e)
{
    var id = $(this).data('id');

    var offset = $(this);
    var win = $(window);

    e.preventDefault();

    e.stopPropagation();

    $('.edit-parking-container').remove();            

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/' + id + '/edit',
        type: 'get',
        dataType: 'json',
        success: function(data)
        {
            $('.parking-lot-container #link' + id).append(data.html);
            $('.edit-parking-container').show();
        }

    })

});

</script>