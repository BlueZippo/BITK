@extends('layouts.master')

@section('content')
	<ul class="nav nav-pills">
  		<li class="nav-item">
    		<a class="nav-link" href="#">Create</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" href="#">Explore</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" href="#">Parking Lot</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" href="#">Profile</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" href="#">Skills & Topics</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" href="#">People</a>
  		</li>
  		<li class="nav-item">
    		<a class="nav-link" href="#">Tags</a>
  		</li>
	</ul>

	<h2>Links I'm Following</h2>

	<div class="row">

	</div>	

	<h2>People I'm Following</h2>

	<div class="row">

	</div>	

	<h2>My Links</h2>

	<div class="row my-links">

		<div class="col-md-4">

			<a href="/links/create" class="create-link">	<span>Create a Link</span></a>

		</div>

		<div class="col-md-4">	

			@if (count($data['mylinks']) > 0)
				<div class="row">
					@foreach($data['mylinks'] as $link)
						<div class="col-md-4">
							<h3>{{$link->title}}</h3>
							<small>{{$link->subtitle}}</small>
						</div>
					@endforeach
				</div>
			@endif

		</div>
		
		<div class="col-md-4">	

			<a class="set-link-reminder">Set a reminder on a link</a>

		</div>	

	

		<div class="col-md-12 text-center">

				<a class="view-all">View All</a>

		</div>

	

	</div>


	<h2>Links Recommended for you</h2>

	<div class="row">

	</div>		


	<h2>Tags</h2>

	<div class="row">

	</div>	


	<h2>Parking Lot</h2>

	<div class="row">

	</div>	
@endsection