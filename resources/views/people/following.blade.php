<div class="dragdrop-target" data-id="dashboard-people-following">

	<div class="stack-panel stack-panel-people dragdrop">

		<div class="panel-heading"><h3><span>People</span> I'm Following</h3></div>

		<div class="panel-body">

			<div class="row">

				@if ( $people )

					@foreach($people as $person)

						<div class="col-md-2 people-{{$person->id}}" id="people-{{$person->id}}">

							@include('people.box')

						</div>

					@endforeach

				@else

					<div class="no-stacks"><p>You're not following anybody, <a href="/people" target="_self">check our other People's</a> ideas to find something you like.</p></div>

				@endif

			</div>

		</div>

	</div>

</div>
