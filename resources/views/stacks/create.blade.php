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

                    {{Form::label('subtitle', 'Sub Title')}}
                    {{Form::text('subtitle', '', ['class' => 'form-control', 'placeholder' => 'Sub Title'])}}

                </div>  

                <div class="form-group">

                    {{Form::label('content', 'Content')}}
                    {{Form::textarea('content', '', ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

                </div>                 

                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection