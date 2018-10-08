@extends('layouts.master')

@section('content')

<h1>Create Link</h1>

{!! Form::open(['url' => action('LinksController@update', ['id' => $link->id]), 'method' => 'POST']) !!}

	<div class="form-group">

		{{Form::label('title', 'Title')}}
		{{Form::text('title', $link->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}

	</div>	

	<div class="form-group">

		{{Form::label('link', 'Link')}}
		{{Form::text('link', $link->link, ['class' => 'form-control', 'placeholder' => 'Link'])}}

	</div>	

	<div class="form-group">

		{{Form::label('stack', 'Choose Where to Save Link')}}		
		
		@foreach($stacks as $stack)
			<div class="form-check">
				
				@if ($link->stack->contains($stack->id))
				{{Form::checkbox('stack[]', $stack->id, true, ['class' => 'form-check-input'])}}
				@else
				{{Form::checkbox('stack[]', $stack->id, false, ['class' => 'form-check-input'])}}
				@endif

				<label class="form-check-label">{{$stack->title}}</label>
			</div>		
		@endforeach

	</div>

	<div class="form-group">
	
		{{Form::label('category', 'Choose Media Category')}}		

		@foreach($categories as $category)

		<div class="form-check">		

			@if ($link->category->contains($category->id))
			{{Form::checkbox('category[]', $category->id, true, ['class' => 'form-check-input'])}}
			@else
			{{Form::checkbox('category[]', $category->id, false, ['class' => 'form-check-input'])}}
			@endif
			<label class="form-check-label">{{$category->cat_name}}</label>

		</div>

		@endforeach

	</div>	

	{{Form::hidden('_method', 'PUT')}}
	{{Form::submit('Save', ['class' => 'btn btn-primary'])}}
	}

{!! Form::close() !!}

@endsection