

<script>

var linkCounter = {{count($links)}};

function stack_autosave()
{    

    $('main.container').append('<div class="autosave">Saving...</div>');

    $('.dotted').each(function()
    {
        var field = $(this).data('field');

        var content = $('.content', this).html();           

        switch (field)
        {
            case 'title':

                $('input[name=title]').val(content);          

            break;

            case 'content':

                $('input[name=content]').val(content);

            break;
            
        }           
    });

    $.ajax(
    {
        url: '/stacks/autosave',
        data: data = $('.edit-stack form').serialize(),
        method: 'post',
        dataType: 'json',
        success: function(data)
        {
            $('main.container .autosave').remove();
            $('input[name=id]').val(data.id);
        }
    })
}

$(document).ready(function()
{

    var autoSve = setInterval(stack_autosave, 60 * 1000);

    $('.modal-body select[name=media_type]').change(function()
    {
        var inp = $(this).val();

        $('.media-field').removeClass('active');

        $('.modal-body input[name='+inp+']').addClass('active');

    });

    $('a.fa-edit').click(function()
    {
        var par = $(this).parent();

        var field = $(par).data('field');

        if (field == 'topics')
        {
            $('.categories-popup').show();
        }   
        else
        {    
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
       }     
    });

    $('.dotted .content').focusout(stack_autosave)

    $('.switch').click(function()
    {  
        var fld = 'status_id';
        var lblOff = 'Draft';
        var lblOn = 'Published';

        if ($(this).hasClass('public'))
        {
            fld = 'private';
            lblOff = 'Public';
            lblOn = 'Private';
        }    

        $(this).toggleClass("switchOn");

        if ($(this).hasClass("switchOn"))
        {
            $('input[name='+fld+']').val(1);
            $(this).html(lblOn);
        }   
        else
        {
            $('input[name='+fld+']').val(0);
            $(this).html(lblOff);
        }

        stack_autosave();

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

    $('.links-nav a.active').trigger('click');

    $('.content').click(function()
    {
        var isEditable = $(this).attr('contenteditable');

        if (isEditable == "true")
        {
            $(this).focus();
            $(this).removeClass('error');
        }    
    });

    $('a.save').click(function()
    {
        $('form').submit();
    });

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

        var html = '<div class="col-md-3 category' +category+ '" id="link'+linkCounter+'">';        

        html += '<div class="single-link">'
        html += '<input type="hidden" name="links['+linkCounter+'][id]" value="0">'
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

        stack_autosave();
    });


    $('#youtubeModal #uploadForm').on('submit', function(e) 
    {

        e.preventDefault();       

        $.ajax({
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  },
          url: "/stacks/upload",
          type: "POST",
          dataType:'json',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function(data)
          { 
            var img = '<img src="'+data.photo+'" width="100%" height="315"><br /><a data-toggle="modal" data-target="#youtubeModal">New Video</a>'

            $('input[name=video_id]').val(data.photo);

            $('.youtube').html(img);

            stack_autosave();
          }
    });

  });


    $('#youtubeModal .btn-primary').click(function()
    {

        var mediaType = $('#youtubeModal select[name=media_type]').val();

        $('input[name=media_type]').val(mediaType);

        if (mediaType == 'youtube')
        {    
            var url = $('#youtubeModal input[name=youtube]').val();

            url = url.split('=');

            if (url[1])
            {
                var iframe  = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'+url[1]+'?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><br /><a data-toggle="modal" data-target="#youtubeModal">New Image/Video</a>';

                $('.youtube').html(iframe);                

                $('input[name=video_id]').val(url[1]);

                $('#youtubeModal').modal('hide');

                stack_autosave();
            }
        }
        else if (mediaType == 'image')
        {
            var url = $('#youtubeModal input[name=image]').val();
            var img = '<img src="'+url+'" width="100%" height="315"><br /><a data-toggle="modal" data-target="#youtubeModal">New Image/Video</a>'

            $('.youtube').html(img);

            $('input[name=video_id]').val(url);

            $('#youtubeModal').modal('hide');

            stack_autosave();

        }   
        else if (mediaType == 'upload') 
        {
            $('#youtubeModal .btn-primary').val('Uploading, please wait...');

            $('#youtubeModal #uploadForm').submit();

            $('#youtubeModal').modal('hide');
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

    $('.categories-popup a.btn-primary').click(function()
    {
        $('.categories-popup').hide();
    });

    $('.categories-popup input[type=checkbox]').click(function()
    {
        $('.categories-content').html('');

        var topics = [];

        $('.categories-popup input[type=checkbox]').each(function()
        {
            if ($(this).is(':checked'))
            {
                topics.push($(this).data('label'));
            }    


        });

        $('.categories-content').html(topics.join(", "));

        stack_autosave();
    })
  
}); 

</script>