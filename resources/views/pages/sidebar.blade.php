
<div class="sidebar">

	<div class="inner mb-2">

		<div class="user-hero-image mb-5" @if($user->background) style="background-image:url({{$user->background}})" @endif >

			<div class="avatar">
	        
	        	@if ($user->photo)
	        		<img id="profile-img" src="{{$user->photo}}">
	        	@else
	        		<img id="profile-img" src="/public/no-image-available.png">
	         	@endif

	         </div>

		</div>

		<div class="name text-center">{{$user->name}}</div>
		<div class="handle text-center mb-3">{{'@' . $user->instagram}}</div>

		<div class="row user-score">

			<div class="col-md-4 text-center">

				<span>Stacks</span>

				{{count($stacks)}}

			</div>

			<div class="col-md-4 text-center">

				<span>Following</span>
				{{count($following)}}

			</div>

			<div class="col-md-4 text-center">

				<span>Followers</span>
				{{count($followers)}}
			</div>

		</div>

	</div>


	<div class="inner">

		<ul class="nav nav-fill nav-pills">
		  <li class="nav-item">
		    <a class="nav-link active" data-toggle="tab" href="#followers">Followers <span>{{count($followers)}}</span></a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" data-toggle="tab" href="#following">Following <span>{{count($following)}}</span></a>
		  </li>
		  
		</ul>

		<div class="tab-content">

			<div class="tab-pane fade show active" id="followers">

				<div class="row">
					
					<div class="form-group col-md-12">

						{{Form::text('search_followers', '', ['class' => 'form-control', 'placeholder' => 'Search Followers']) }}

					</div>

				</div>

				@foreach($followers as $person)

					@php 

					$person = $person->people; 

					@endphp

					<div class='row'>

						<div class="col-md-12">

							@include('pages.sidebar-follow-people-box')

						</div>

					</div>

				@endforeach

			</div>

			<div class="tab-pane fade" id="following">

				<div class="row">
					
					<div class="form-group col-md-12">

						{{Form::text('search_following', '', ['class' => 'form-control', 'placeholder' => 'Search Following']) }}

					</div>

				</div>

				@foreach($following as $person)

					@php 

					$person = $person->user;

					@endphp

					<div class='row'>

						<div class="col-md-12">

							@include('pages.sidebar-follow-people-box')

						</div>

					</div>

				@endforeach

			</div>

		</div>


	</div>


</div>