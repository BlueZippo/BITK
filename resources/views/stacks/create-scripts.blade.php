<script>

var linkCounter ={{$linkCounter}}

$(document).ready(function()
{
    $('input[name=link_url]').change(function()
    {
       
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
            }
        });
    });

    $('.add-link-button').click(function()
    {
        var title = $('input[name=link_title]').val();
        var url = $('input[name=link_url]').val();
        var desc = $('textarea[name=link_description]').val();
        var img = $('.link-image img').attr('src');

        linkCounter++;

        var html = '<div class="col-md-3 single-link" id="link'+linkCounter+'">';        

        html += '<input type="hidden" name="links['+linkCounter+'][url]" value="'+url+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][title]" value="'+title+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][description]" value="'+desc+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][image]" value="'+img+'">'

        html += '<div class="image"><img src="' +img + '"></div>'
        html += '<div class="title">' + title + '</div>';

        html += '<div class="link-hover"><a data-id='+linkCounter+' onClick="$(\'#link'+linkCounter+'\').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>';

        html += '</div>';

        $('.stack-links').append(html);

        $('input[name=link_title]').val('');
        $('input[name=link_url]').val('');
        $('textarea[name=link_description]').val('');
        $('.link-image img').attr('src', '');
    });


  
}); 

</script>