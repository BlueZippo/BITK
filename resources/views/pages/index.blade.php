@extends('layouts.master')

@section('content')

	<div class="dashboard">
	
		@include('pages.nav')

		@include('stacks.following')

		@include('people.following')

		@include('stacks.mystacks')

		@include('stacks.recommended')

		@include('pages.tags')

		@include('pages.parking')

	</div>	

		
@endsection