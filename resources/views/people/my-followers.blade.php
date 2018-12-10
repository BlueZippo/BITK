<div class="dragdrop-target">

	<div class="stack-panel stack-panel-people dragdrop">

		<div class="panel-heading"><h3>My <span>Followers</span></h3></div>

		<div class="panel-body">

			<div class="row">

				@if ( $followers )

					@foreach($followers as $person)

						<div class="col-md-2 people-{{$person->id}}" id="people-{{$person->id}}">

							@include('people.box')

						</div>

					@endforeach

				@else

					<div class="no-stacks">You do not have followers yet</div>

				@endif

			</div>

		</div>

	</div>

</div>