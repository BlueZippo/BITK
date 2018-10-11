@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-8">
            
			<h1>Edit Stack</h1>
            
            <hr />

            {!! Form::open(['action' => ['StacksController@update', $stack->id], 'method' => 'POST']) !!}

                @include('stacks.youtube')

                {{Form::hidden('id', $stack->id)}}
                {{Form::hidden('video_id', $stack->video_id)}}

                <div class="form-group">

                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', $stack->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}

                    <span class="small">Last updated: {{date("M d, Y", strtotime($stack->updated_at))}}</span>

                </div>  

                

                <div class="form-group">

                    {{Form::label('content', 'Content')}}
                    {{Form::textarea('content', $stack->content, ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

                </div>    

                @include('stacks.meta-author')

                <div class="row stack-links">

                    @php $linkCounter = 0; @endphp

                    @if (count($links))

                        @foreach($links as $link)

                            <div class="col-md-3 single-link" id="link{{$linkCounter}}">
                                <input type="hidden" name="links[{{$linkCounter}}][url]" value="{{$link['link']}}">
                                <input type="hidden" name="links[{{$linkCounter}}][title]" value="{{$link['title']}}">
                                <input type="hidden" name="links[{{$linkCounter}}][description]" value="{{$link['description']}}">
                                <input type="hidden" name="links[{{$linkCounter}}][image]" value="{{$link['image']}}">
                                <div class="image"><img src="{{$link['image']}}"></div>
                                <div class="title">{{$link['title']}}</div>
                                <div class="link-hover"><a data-id={{$linkCounter}} onClick="$('#link{{$linkCounter}}').remove()" class="btn btn-primary link-delete-button"><i class="fa fa-minus"></i></a></div>
                            </div>  

                            @php $linkCounter++ @endphp


                        @endforeach

                    
                    @endif


                </div>     

                @include('stacks.add-link')

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>



@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection

