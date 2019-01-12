<div class="user-image">
	<a href="{{url('/people/' . $person->id . '/stacks')}}">
		@if ($person->photo)
			<div class="avatar">
				<img src="{{url($person->photo)}}" alt="{{$person->name}}">
			</div>
		@else
			<div class="avatar">{{ render_initials( $person->name ? $person->name : $person->email   ) }}</div>
		@endif
	</a>
</div>