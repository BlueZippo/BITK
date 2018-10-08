@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-8">
            
			<h1>Edit Stack</h1>
            
            <hr />

            {!! Form::open(['action' => ['StacksController@update', $stack->id], 'method' => 'POST']) !!}

                {{Form::hidden('id', $stack->id)}}

                <div class="form-group">

                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', $stack->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}

                </div>  

                <div class="form-group">

                    {{Form::label('subtitle', 'Sub Title')}}
                    {{Form::text('subtitle', $stack->subtitle, ['class' => 'form-control', 'placeholder' => 'Sub Title'])}}

                </div>  

                <div class="form-group">

                    {{Form::label('content', 'Content')}}
                    {{Form::textarea('content', $stack->content, ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

                </div>                 

                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection