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

		@include('stacks.following')

		@include('people.following')

		@include('stacks.mystacks')

		@include('stacks.recommended')

		@include('pages.tags')

		@include('pages.parking')

       

	</div>

@endsection

