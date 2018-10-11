@extends ('layouts.master')

@section('content')

	<div class="row">
        
		<div class="col-sm-8">
            
			<h1>Create A Stack</h1>
            
            <hr />

            {!! Form::open(['action' => 'StacksController@store', 'method' => 'POST']) !!}

                @include('stacks.youtube')

                {{Form::hidden('video_id', 0)}}

                <div class="form-group">

                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}                    

                </div>  

               

                <div class="form-group">

                    {{Form::label('content', 'Content')}}
                    {{Form::textarea('content', '', ['class' => 'form-control textarea', 'placeholder' => 'Content'])}}

                </div>    

                @php $linkCounter = 0; @endphp    

                @include('stacks.meta-author') 

                @include('stacks.links')  

                @include('stacks.add-link-form')

                {{Form::submit('Save', ['class' => 'btn btn-primary'])}}

            {!! Form::close() !!}

		</div>
        
	</div>

@endsection

@section('scripts')
@include('stacks.create-scripts')
@endsection