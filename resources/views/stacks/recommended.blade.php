<div class="panel panel-default">

	<div class="panel-heading">Stacks Recommended for you</div>

	<div class="panel-body">

		<div class="row">

			@if (count($stacks) > 0)

				@foreach($stacks as $stack)

					<div class="col-md-2">

						<div class="well">

							<a href="/stacks/{{$stack->id}}/dashboard">

							<h4>{{$stack->title}}</h4>
							<small>{{$stack->subtitle}}</small>					

							</a>

						</div>

					</div>	

				@endforeach

			@endif
		</div>

	</div>

</div>		