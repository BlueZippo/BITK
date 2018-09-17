@extends('layouts.master')

@section('content')
	
	@include('pages.nav')

	@include('links.following')

	@include('people.following')

	@include('links.mylinks')

	@include('links.recommended')

	@include('pages.tags')

	@include('pages.parking')

		
@endsection