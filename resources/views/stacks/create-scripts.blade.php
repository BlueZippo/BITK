

<script>

var linkCounter = {{count($links)}};

$(document).ready(function()
{

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


    $('.links-nav a').click(function()
    {
        $('.links-nav a').removeClass('active');

        $(this).addClass('active');

        $('.add-link-button-wrapper').hide();

        $('.stack-links > div').hide();

        if ($(this).hasClass('category-button'))
        {
            var category = $(this).data('category');

            $('.add-link-button-wrapper').show();

            $('.stack-links > div.category' + category).show();
        }
        else if ($(this).hasClass('top-three'))
        {
            $('.stack-links #link0').show();
            $('.stack-links #link1').show();
            $('.stack-links #link2').show();
        }
        else
        {
            $('.stack-links > div[class*=category').show();
        }

    });

    $('.content').click(function()
    {
        var isEditable = $(this).attr('contenteditable');

        if (isEditable == "true")
        {
            $(this).focus();
            $(this).removeClass('error');
        }    
    })

    $('form').submit(function()
    {
        var error = false;

        $('.dotted').each(function()
        {
            var field = $(this).data('field');

            var content = $('.content', this).html();           

            switch (field)
            {
                case 'title':

                    $('input[name=title]').val(content);

                    if (content == 'enter title...' || content == '')
                    {
                        error = true;
                        $(this).addClass('error');
                    }

                break;

                case 'content':

                    if (content != 'enter description...')
                    {
                        $('input[name=content]').val(content);
                    }    

                break;
                
            }


           
        });




        if (error)
         {

            return false;
         } 
    })

    $('input[name=link_url]').focusout(function()
    {
        $('.submit-button').addClass('disabled');

        $('.solid .content').html('Fetching link information, please wait...')
       
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

                $('.submit-button').removeClass('disabled');
            }
        });
    });

    $('.add-link .submit-button').click(function()
    {
        var title = $('*[data-field="link_title"] .content').html();
        var url = $('input[name=link_url]').val();
        var desc = $('*[data-field="link_description"] .content').html();
        var img = $('.image-container img').attr('src');

        var category = $('.links-nav a.active').data('category');

        linkCounter++;

        var html = '<div class="col-md-3" id="link'+linkCounter+'">';        

        html += '<div class="single-link">'

        html += '<input type="hidden" name="links['+linkCounter+'][url]" value="'+url+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][title]" value="'+title+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][description]" value="'+desc+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][image]" value="'+img+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][media_id]" value="'+category+'">'

        html += '<div class="image"><img src="' +img + '"></div>'
        html += '<div class="title">' + title + '</div>';

        html += '<div class="link-hover"><a data-id='+linkCounter+' onClick="$(\'#link'+linkCounter+'\').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>';

        html += '</div>';

        html += '</div>';        

        $('.add-link-button-wrapper').before(html);

        $('*[data-field="link_title"] .content').html('');
        $('input[name=link_url]').val('');
        $('*[data-field="link_description"] .content').html('');
        $('.image-container').html('');

        $('.links-container').hide();
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
        var offset = $(this).offset();

        $('.links-container').removeClass('right-position');
        $('.links-container').removeClass('left-position');

        $('.links-container').css('right', 'auto');
        $('.links-container').css('left', 'auto');

        console.log(offset);

        if (offset.left < 650)
        {
            $('.links-container').addClass('right-position');
            $('.links-container').css('right', '-505px');
        }   
        else
        {
            $('.links-container').addClass('left-position');
            $('.links-container').css('left', '-505px');
        } 

        $('.links-container').show();
    });

  
}); 

</script>