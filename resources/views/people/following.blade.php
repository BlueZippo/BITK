<div class="panel panel-default">

	<div class="panel-heading">People I'm Following</div>

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
