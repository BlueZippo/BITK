<div class="panel panel-default">

	<div class="panel-heading">Stacks I'm Following</div>

	<div class="panel-body">

		@if (count($follows) > 0)

			<div class="row">

			@foreach($follows as $stack)

				<div class="col-md-2">

					@include('stacks.dashboard-box')

				</div>

			@endforeach

			</div>

	@endif

	</div>

</div>
