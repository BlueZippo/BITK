@extends('layouts.master')



@section('content')


	<div class="dashboard">

		<div class="row">

			<div class="col-md-3">

				@include('pages.sidebar')

			</div>

			<div class="col-md-9">

				@include('pages.dashboard')

			</div>

			

		</div>
       

	</div>

@endsection

@section('scripts')

@include('pages.jscript')

@endsection

