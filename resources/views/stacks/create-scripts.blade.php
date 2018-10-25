

<script>

var linkCounter = {{count($links)}};

$(document).ready(function()
{
    $('input[name=link_url]').focusout(function()
    {
        $('.add-link-button').hide();

        $('.add-link-button').after('<span class="alert alert-danger"><strong>Fetching link details, please wait...</strong></span>');
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax(
        {
            url: '/links/get-meta-tags',
            data: $('.links-container input'),
            type: 'post',
            dataType: 'json',
            success: function(data)
            {
                if (data.title)
                {
                    $('input[name=link_title]').val(data.title);
                }

                if (data.description)
                {
                    $('textarea[name=link_description]').val(data.description);
                }

                if (data.image)
                {
                    $('.link-image img').attr('src', data.image);
                }

                $('.alert').hide();
                $('.add-link-button').show();
            }
        });
    });

    $('.add-link-button').click(function()
    {
        var title = $('input[name=link_title]').val();
        var url = $('input[name=link_url]').val();
        var desc = $('textarea[name=link_description]').val();
        var img = $('.link-image img').attr('src');

        var category = $('input[name=link_category]').val();

        linkCounter++;

        var html = '<div class="col-md-3 single-link" id="link'+linkCounter+'">';        

        html += '<input type="hidden" name="links['+linkCounter+'][url]" value="'+url+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][title]" value="'+title+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][description]" value="'+desc+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][image]" value="'+img+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][media_id]" value="'+category+'">'

        html += '<div class="image"><img src="' +img + '"></div>'
        html += '<div class="title">' + title + '</div>';

        html += '<div class="link-hover"><a data-id='+linkCounter+' onClick="$(\'#link'+linkCounter+'\').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>';

        html += '</div>';


        $('#addLinkModal').modal('hide');

        $('#category'+category+' .stack-links').append(html);

        $('input[name=link_title]').val('');
        $('input[name=link_url]').val('');
        $('textarea[name=link_description]').val('');
        $('.link-image img').attr('src', '');
    });


    $('#youtubeModal .btn-primary').click(function()
    {
        var url = $('#youtubeModal input[name=youtube]').val();

        url = url.split('=');

        if (url[1])
        {
            var iframe  = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'+url[1]+'?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><br /><a data-toggle="modal" data-target="#youtubeModal">New Video</a>';

            $('.youtube').html(iframe);

            $('#youtubeModal').modal('hide');

            $('input[name=video_id]').val(url[1]);
        }    

    });


    $('.add-link-modal').click(function()
    {
        category = $(this).data('category');

        $('#addLinkModal input[name=link_category]').val(category);
    });

  
}); 

</script>