<div class="people-box">

	<div class="header" @if($person->background) style="background-image:url({{$person->background}})" @else  style="background-image:url( {{asset('images/stack-placeholder.png')}} )" @endif ></div>

	<div class="user-image-follow-wrapper">
		<div class="user-image">
			<a href="/people/{{$person->id}}/stacks">
				@if ($person->photo)
				  <img src="{{$person->photo}}" alt="{{$person->name}}">
				@else
					<div class="avatar">{{ render_initials( $person->name ? $person->name : $person->email   ) }}</div>
				@endif
			</a>
		</div>
		<div class="follow">
			@if ($peopleFollows->contains($person->id))
				<a data-action="unfollow" data-id="{{$person->id}}" class="follow-people-button unfollow">Following</a>
			@else
				<a data-action="follow" data-id="{{$person->id}}" class="follow-people-button">Follow</a>
			@endif
		</div>
	</div>

	<div class="user-name-wrapper">
		<h3>{{$person->name}}</h3>
		@if($person->instagram)<h4>{{'@'.$person->instagram}}</h4>@endif
	</div>

	<div class="user-profile-wrapper">
		<p>{{$person->profile}}</p>
	</div>

</div>

<p><a href="/person/{{$person->id}}" target="_blank">Profile Test Link</a></p>
