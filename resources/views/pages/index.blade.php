@extends('layouts.master')

@section('style')

<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
<link href="{{ asset('js/plugins/custom/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

@endsection


@section('content')


	<div class="dashboard">

		<div class="nav-wrapper">
			@include('pages.nav')

			{{--@include('pages.layout-control')--}}

		</div>

		@if ($dashboard)
		
			@foreach($dashboard as $db)

				@if ($db == 'dashboard-stacks-following')

					@include('stacks.following')

				@endif

				@if ($db == 'dashboard-followers')

					@include('people.my-followers')

				@endif

				@if ($db == 'dashboard-people-following')

					@include('people.following')

				@endif

				@if ($db == 'dashboard-mystacks')

					@include('stacks.mystacks')

				@endif

				@if ($db == 'dashboard-recommended')

					@include('stacks.recommended')

				@endif

				@if ($db == 'dashboard-parking-lot')

					@include('pages.parking')

				@endif

				@if ($db == 'dashboard-tags')

					@include('pages.tags')

				@endif

				 

			@endforeach

		@else

			@include('stacks.following')

			@include('people.my-followers')

			@include('people.following')

			@include('stacks.mystacks')

			@include('stacks.recommended')

			@include('pages.tags')

			@include('pages.parking')

		@endif

		

		

       

	</div>

@endsection

