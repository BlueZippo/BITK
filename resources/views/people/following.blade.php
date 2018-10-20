<div class="panel panel-default">

	<div class="panel-heading">People I'm Following</div>

	<div class="panel-body">

		<div class="row">

			@foreach($people as $person)

				<div class="col-md-3">	

					<div class="well well-lg">

						<a href="/people/{{$person->id}}/stacks"><h3>{{$person->name}}</h3>
						

					</div>	

				</div>	

			@endforeach

		</div>	

	</div>

</div>
