

<script>

var linkCounter = {{count($links)}};

function stack_autosave()
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
                }

            break;

            case 'content':

                $('input[name=content]').val(content);

            break;

        }
    });

    var params = $('.edit-stack form').serialize();

    if (!error)
    {   

        $('main.container').append('<div class="autosave">Saving...</div>'); 

        $.ajax(
        {
            url: '/stacks/autosave',
            data: params,
            method: 'post',
            dataType: 'json',
            success: function(data)
            {
                $('main.container .autosave').remove();
                $('input[name=id]').val(data.id);
            }
        });
    }
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

    $('.edit-stack .back').click(function()
    {
        location = '/dashboard';
    });

    $('.edit-stack .trash').click(function()
    {
        var id = $('input[name=id]').val();

        if (id > 0)
        {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax(
            {
                url: '/stacks/trash',
                type: 'post',
                data: 'id=' + id,
                success:function()
                {
                    location = '/dashboard';
                }
            })
        }
        else
        {
            location = '/dashboard';
        }
    })

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

    $('.dotted .content').focusout(stack_autosave);



    $('.switch').click(function()
    {
        var fld = 'status_id';
        var lblOff = 'Draft';
        var lblOn = 'Published';
        var isPublic = false;

        if ($(this).hasClass('public'))
        {
            fld = 'private';
            lblOff = 'Private';
            lblOn = 'Public';
            isPublic = true;
        }

        $(this).toggleClass("switchOn");

        if ($(this).hasClass("switchOn"))
        {
            if (isPublic)
            {
                $('input[name='+fld+']').val(0);
            }   
            else
            { 
                $('input[name='+fld+']').val(1);
            }
                
            $(this).html(lblOn);
        }
        else
        {
            if (isPublic)
            {
                $('input[name='+fld+']').val(1);
            }   
            else
            { 
                $('input[name='+fld+']').val(0);
            }

            $(this).html(lblOff);
        }

        stack_autosave();

    });


    $('.links-nav a').click(function()
    {
        $('.links-nav a').removeClass('active');

        $(this).addClass('active');

        $('.add-link-button-wrapper').hide();

        $('.tabbed-panel .stack-links > div').hide();

        if ($(this).hasClass('category-button'))
        {
            var category = $(this).data('category');

            $('.add-link-button-wrapper').show();

            $('.tabbed-panel .stack-links > div.category' + category).show();
        }
        else if ($(this).hasClass('top-three'))
        {
            $('.tabbed-panel .stack-links #link0').show();
            $('.tabbed-panel .stack-links #link1').show();
            $('.tabbed-panel .stack-links #link2').show();
        }
        else
        {
            $('.tabbed-panel .stack-links > div[class*=category').show();
        }

    });

    $('.links-nav a.active').trigger('click');

    $('.content').click(function(e)
    {
        e.preventDefault();

        e.stopPropagation();

        $('.categories-popup').hide();

        var isEditable = $(this).attr('contenteditable');
        var content = $(this).html();

        if (isEditable == "true")
        {
            $(this).focus();
            $(this).removeClass('error');
        }

        if ($(this).hasClass('categories-content'))
        {
            $('.categories-popup').show();
        }

        if (content == 'enter title...' || content == 'enter description...')
        {
            $(this).html('');
        }
    });


    $('.categories-popup').click(function(e)
    {
        e.stopPropagation();
    })

    $('a.save, .edit-stack .save').click(function()
    {
        $('form').submit();
    });

    $('.edit-stack .clone').click(function()
    {
        $.ajax(
        {
            url: '/stacks/' + $('input[name=id]').val() + '/clone',
            type: 'get',
            dataType: 'json',
            success: function(data)
            {
                location = '/stacks/' + data.id + '/edit';
            }
        });
    });

    $('.edit-stack .preview').click(function()
    {
        stack_autosave();

        var id = $('input[name=id]').val();

        var win = window.open('/stacks/' + id + '/preview', 'previewn', 'scrollbars, resizable, width=1500, height=1000');

        win.focus();

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

    $('.links-container .submit-button').click(function()
    {
        var title = $('*[data-field="link_title"] .content').html();
        var url = $('.links-container input[name=link_url]').val();
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
        html += '<input type="hidden" name="links['+linkCounter+'][code]" value="">'

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
            var img = '<div class="featured-image-upload"><img src="'+data.photo+'" width="100%" height="315" /></div><p class="featured-upload-btn"><a data-toggle="modal" data-target="#youtubeModal"><i class="fas fa-file-upload"></i> New Image/Video</a></p>'

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

            if (url.indexOf('youtu.be') > 0)
            {
                url = url.split('/');

                youtubeID = url[3];
            }   
            else
            { 
                url = url.split('=');

                if (url[1])
                {
                    youtubeID = url[1];        
                }
                else
                {
                    youtubeID = url[0];
                }
            }

            //console.log(youtubeID);


            var iframe  = '<iframe width="100%" height="315" src="https://www.youtube.com/embed/'+youtubeID+'?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><p class="featured-upload-btn"><a data-toggle="modal" data-target="#youtubeModal"><i class="fas fa-file-upload"></i> New Image/Video</a></p>';

            $('.youtube').html(iframe);

            $('input[name=video_id]').val(youtubeID);

            $('#youtubeModal').modal('hide');

            stack_autosave();
        }
        else if (mediaType == 'image')
        {
            var url = $('#youtubeModal input[name=image]').val();
            var img = '<div class="featured-image-upload"><img src="'+url+'" width="100%" height="315" /></div><p class="featured-upload-btn"><a data-toggle="modal" data-target="#youtubeModal"><i class="fas fa-file-upload"></i> New Image/Video</a></p>'

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
        var body = document.body;
        var html = document.documentElement;
        var modalHeight = $('.links-container').height();

        var docHeight = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.offsetHeight);
        

        $('.links-container').removeClass('right-position');
        $('.links-container').removeClass('left-position');
        $('.links-container').removeClass('middle-position');

        $('.links-container').css('right', 'auto');
        $('.links-container').css('left', 'auto');

        
        

        console.log(offset.top);
        console.log(modalHeight);
        console.log(docHeight);

        if ((offset.top + modalHeight) > docHeight)
        {
            $('.links-container').addClass('middle-position');
        }    
        

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

    stack_layout_control($);

});

function stack_layout_control($) {

    var control_layout = $('.edit-stack-layout-controls');
    var button = $('.edit-stack-layout-controls > nav > .nav-tabs > a');

    if( control_layout.length ) {

        button.on('click', function() {
            button.removeClass('active show');
            button.attr('aria-selected', false);
            $(this).addClass('show');
            $(this).attr('aria-selected', true);
        });

    }

}

</script>
