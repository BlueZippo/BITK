<div class="user-image">
	<a href="{{url('/people/' . $person->id . '/stacks')}}">
		@if ($person->photo)
				<img src="{{url($person->photo)}}" alt="{{$person->name}}">
		@else
			<div class="avatar">{{ render_initials( $person->people->name ? $person->people->name : $person->people->email   ) }}</div>
		@endif
	</a>
</div>

<div class="name">{{$person->people->name}}</div>
<div class="handle">{{'@'.$person->people->instagram}}</div>

<a href="#" class="btn btn-primary">Following</a>

<a href="#">...</a>