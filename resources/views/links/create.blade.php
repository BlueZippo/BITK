@extends('layouts.master')

@section('content')

<h1>Create Link</h1>

{!! Form::open(['action' => 'LinksController@store', 'method' => 'POST']) !!}

	<div class="form-group">

		{{Form::label('title', 'Title')}}
		{{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

	</div>	

	<div class="form-group">

		{{Form::label('subtitle', 'Sub Title')}}
		{{Form::text('subtitle', '', ['class' => 'form-control', 'placeholder' => 'Sub Title'])}}

	</div>	

	<div class="form-group">

		{{Form::label('description', 'Descrition')}}
		{{Form::textarea('description', '', ['class' => 'form-control textarea', 'placeholder' => 'Description'])}}

	</div>	

	<div class="form-group">

		{{Form::label('link', 'Link')}}
		{{Form::text('link', '', ['class' => 'form-control', 'placeholder' => 'Link'])}}

	</div>	

	{{Form::submit('Save', ['class' => 'btn btn-primary'])}}

{!! Form::close() !!}

@endsection