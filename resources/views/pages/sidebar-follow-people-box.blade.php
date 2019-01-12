<div class="user-image">
	<a href="{{url('/people/' . $person->id . '/stacks')}}">
		@if ($person->photo)
				<img src="{{url($person->photo)}}" alt="{{$person->name}}">
		@else
			<div class="avatar">{{ render_initials( $person->name ? $person->name : $person->email   ) }}</div>
		@endif
	</a>
</div>

<div class="name">{{$person->name}}</div>
<div class="handle">{{'@'.$person->instagram}}</div>

<a href="#" class="btn btn-primary">Following</a>

<a href="#">...</a>