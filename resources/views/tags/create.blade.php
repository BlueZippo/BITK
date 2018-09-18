@extends('layouts.master')

@section('content')

<h1>Add Tag</h1>

{!! Form::open(['action' => 'TagsController@store', 'method' => 'POST']) !!}

	<div class="form-group">

		{{Form::label('tag', 'Tag')}}
		{{Form::text('tag', '', ['class' => 'form-control', 'placeholder' => 'Tag'])}}

	</div>	
	
	{{Form::submit('Save', ['class' => 'btn btn-primary'])}}

{!! Form::close() !!}

@endsection