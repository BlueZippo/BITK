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


                @include('stacks.add-link')

                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection