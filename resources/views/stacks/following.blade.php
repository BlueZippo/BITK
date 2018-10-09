<div class="panel panel-default">

	<div class="panel-heading">Stacks I'm Following</div>

	<div class="panel-body">

		@if (count($follows) > 0)

			<div class="row">	

			@foreach($follows as $follow)

				<div class="col-md-3">	

					<div class="well well-lg">

						<a href="/stacks/{{$follow->stack->id}}/dashboard"><h3>{{$follow->stack->title}}</h3>
						<small>{{$follow->stack->subtitle}}</small></a>

					</div>	

				</div>	

			@endforeach	

			</div>

	@endif

	</div>	

</div>