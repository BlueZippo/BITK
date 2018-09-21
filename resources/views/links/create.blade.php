@extends('layouts.master')

@section('content')

<h1>Create Link</h1>

{!! Form::open(['action' => 'LinksController@store', 'method' => 'POST']) !!}

	<div class="form-group">

		{{Form::label('title', 'Title')}}
		{{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

	</div>	

	<div class="form-group">

		{{Form::label('link', 'Link')}}
		{{Form::text('link', '', ['class' => 'form-control', 'placeholder' => 'Link'])}}

	</div>	

	<div class="form-group">

		{{Form::label('stack', 'Choose Where to Save Link')}}		
		
		@foreach($stacks as $stack)
			<div class="form-check">
				{{Form::checkbox('stack[]', $stack->id, false, ['class' => 'form-check-input'])}}
				<label class="form-check-label">{{$stack->title}}</label>
			</div>		
		@endforeach

	</div>

	<div class="form-group">
	
		{{Form::label('category', 'Choose Media Category')}}		

		@foreach($categories as $category)

		<div class="form-check">		

			{{Form::checkbox('category[]', $category->id, false, ['class' => 'form-check-input'])}}
			<label class="form-check-label">{{$category->cat_name}}</label>

		</div>

		@endforeach

	</div>	

	{{Form::submit('Save', ['class' => 'btn btn-primary'])}}

{!! Form::close() !!}

@endsection