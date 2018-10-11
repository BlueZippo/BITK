@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-8">
            
			<h1>Create A Stack</h1>
            
            <hr />

            {!! Form::open(['action' => 'StacksController@store', 'method' => 'POST']) !!}

                <div class="form-group">

                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

                </div>  

               

                <div class="form-group">

                    {{Form::label('content', 'Content')}}
                    {{Form::textarea('content', '', ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

                </div>        

                <div class="row stack-links">

                    @php $linkCounter = 0; @endphp

                    @if (count($links))

                        @foreach($links as $link)

                            <div class="col-md-3">
                                <input type="hidden" name="links[{{$linkCounter}}][url]" value="{{$link['url']}}">
                                <input type="hidden" name="links[{{$linkCounter}}][title]" value="{{$link['title']}}">
                                <input type="hidden" name="links[{{$linkCounter}}][description]" value="{{$link['description']}}">
                                <input type="hidden" name="links[{{$linkCounter}}][image]" value="{{$link['image']}}">
                                <div class="image"><img src="{{$link['image']}}"></div>
                                <div class="title">{{$link['title']}}</div>
                            </div>  

                            @php $linkCounter++ @endphp


                        @endforeach

                    
                    @endif


                </div>         


                <div class="well links-container">

                    <div class="add-link">

                        <h3>Add Link</h3>


                        <div class="form-group">

                            {{Form::label('link_url', 'Pasted Link')}}
                            {{Form::text('link_url', '', ['class' => 'form-control', 'placeholder' => 'Enter the link here....'])}}

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                Link Image:

                                <span class="link-image"><img src=""></span>

                            </div>

                            <div class="col-md-8">

                                <div class="form-group">

                                    {{Form::label('link_title', 'Link Title')}}
                                    {{Form::text('link_title', '', ['class' => 'form-control', 'placeholder' => 'Enter the link title here....'])}}

                                </div>

                                <div class="form-group">

                                    {{Form::label('link_description', 'Link Description')}}
                                    {{Form::textarea('link_description', '', ['class' => 'form-control', 'placeholder' => 'Enter the link description here....'])}}

                                </div>


                            </div>

                        </div>


                        <a class="btn btn-primary add-link-button">Add Link</a>

                    </div>

                </div>

                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection

@section('scripts')

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

        var html = '<div class="col-md-3">';

        linkCounter++;

        html += '<input type="hidden" name="links['+linkCounter+'][url]" value="'+url+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][title]" value="'+title+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][description]" value="'+desc+'">'
        html += '<input type="hidden" name="links['+linkCounter+'][image]" value="'+img+'">'

        html += '<div class="image"><img src="' +img + '"></div>'
        html += '<div class="title">' + title + '</div>';

        html += '</div>';

        $('.stack-links').append(html);

        $('input[name=link_title]').val('');
        $('input[name=link_url]').val('');
        $('textarea[name=link_description]').val('');
        $('.link-image img').attr('src', '');
    });
}); 

</script>

@endsection