<div class="stack-panel">

	<div class="panel-heading"><h3><span>People</span> I'm Following</h3></div>

	<div class="panel-body">

		<div class="row">

			@foreach($people as $person)

				<div class="col-md-2 people-{{$person->id}}" id="people-{{$person->id}}">

					@include('people.box')

				</div>

			@endforeach

		</div>

	</div>

</div>
