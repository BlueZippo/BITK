<script src="{{ asset('js/plugins/chosen/chosen.jquery.min.js') }}"></script>

<link href="{{ asset('js/plugins/chosen/chosen.css') }}" rel="stylesheet">

<script>

var STACKS = {!!$MyStacks!!};

$(document).ready(function()
{
    $('select[name=stack_id]').chosen(
        {

     });
});

$('input[name=link_url]').on('paste', function(e)
{
    var clipboardData, pastedData;

    e.stopPropagation();
    e.preventDefault();

    clipboardData = e.clipboardData || window.clipboardData || e.originalEvent.clipboardData;
    
    pastedData = clipboardData.getData('Text');    

    $(this).val(pastedData);    

    $(this).trigger('change');

});

$('input[name=link_url]').on('change', function()
{
    $('.continue-button').addClass('disabled');

    $('.solid .content').html('Fetching link information, please wait...')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax(
    {
        url: '/links/get-meta-tags',
        data: $('.add-links-container input'),
        type: 'post',
        dataType: 'json',
        success: function(data)
        {
            if (data.title)
            {
                $('*[data-field="link_title"] .content').html(data.title)
            }

            if (data.description)
            {
                $('*[data-field="link_description"] .content').html(data.description);
            }

            if (data.image)
            {
                $('.image-container').html('<img src="'+data.image+'">');
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



</script>